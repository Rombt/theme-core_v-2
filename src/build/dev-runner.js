import { spawn } from "node:child_process";
import browserSync from "browser-sync";

const bs = browserSync.create();

let viteProcess = null;
let isFirstBuildDone = false;
let shuttingDown = false;


function startVite() {
  console.log("[engine] Starting Vite (build --watch)...");

  viteProcess = spawn("npx", ["vite", "build", "--watch","--config src/build/config/vite.config.js"], {
    stdio: ["inherit", "pipe", "pipe"],
    shell: true
  });

  viteProcess.stdout.on("data", (data) => {
    const text = data.toString();
    process.stdout.write(text);

    if (!isFirstBuildDone && /built in|Build complete|build finished/i.test(text)) {
      isFirstBuildDone = true;
      console.log("[engine] First build done.");

      startBrowserSync();
    }
  });

  viteProcess.stdout.on("data", (data) => {
    const text = data.toString();
    process.stdout.write(text);

    if (/built in/i.test(text)) {
      if (!isFirstBuildDone) {
        isFirstBuildDone = true;
        startBrowserSync();
      } else {
        bs.reload();
      }
    }
  });

  viteProcess.stderr.on("data", (data) => {
    process.stderr.write(data.toString());
  });

  viteProcess.on("exit", (code) => {
    if (shuttingDown) return;

    console.error(`[engine] Vite exited with code ${code}. Shutting down.`);
    shutdown(1);
  });

  viteProcess.on("error", (err) => {
    console.error("[engine] Failed to start Vite:", err);
    shutdown(1);
  });
}

function startBrowserSync() {
  if (bs.active) return;

  console.log("[engine] Starting BrowserSync...");

  bs.init(
    {
      proxy: "http://tc-1.multisite",
      files: [
        // "D:/web/multisite/wp-content/themes/tc-1/assets/**/*",
        "D:/web/multisite/wp-content/themes/tc-1/**/*.*",
      ],
      open: false,
      notify: false
    },
    (err, bsInstance) => {
      if (err) {
        console.error("[engine] BrowserSync failed to start:", err);
        shutdown(1);
        return;
      }

      console.log("[engine] BrowserSync is running.");
    }
  );
}

function shutdown(code = 0) {
  if (shuttingDown) return;
  shuttingDown = true;

  console.log("[engine] Shutting down...");

  if (viteProcess) {
    viteProcess.kill("SIGINT");
  }

  if (bs && bs.active) {
    bs.exit();
  }

  setTimeout(() => {
    process.exit(code);
  }, 300);
}

["SIGINT", "SIGTERM", "SIGHUP"].forEach((signal) => {
  process.on(signal, () => {
    console.log(`[engine] Received ${signal}`);
    shutdown(0);
  });
});

startVite();
