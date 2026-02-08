import { spawn } from "node:child_process";
import browserSync from "browser-sync";

const bs = browserSync.create();

let viteProcess = null;
let isFirstBuildDone = false;
let shuttingDown = false;
let reloadTimer = null;

function startVite() {
  console.log("[engine] Starting Vite (build --watch)...");

  viteProcess = spawn(
    "npx",
    ["vite", "build", "--watch", "--config", "src/build/config/vite.config.js"],
    {
      stdio: ["inherit", "pipe", "pipe"],
      shell: true,
    }
  );

  viteProcess.stdout.on("data", (data) => {
    const text = data.toString();
    process.stdout.write(text);

    // триггер только на завершение билда
    if (/built in|build finished|Build complete/i.test(text)) {
      clearTimeout(reloadTimer);

      reloadTimer = setTimeout(() => {
        if (!isFirstBuildDone) {
          isFirstBuildDone = true;
          console.log("[engine] First build done.");
          startBrowserSync();
        } else if (bs.active) {
          console.log("[engine] Reload browser");
          bs.reload();
        }
      }, 200); // debounce
    }
  });

  viteProcess.stderr.on("data", (data) => {
    process.stderr.write(data.toString());
  });

  viteProcess.on("exit", (code) => {
    if (shuttingDown) return;
    console.error(`[engine] Vite exited with code ${code}`);
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
      open: false,
      notify: false,
      ui: false,
      ghostMode: false,
    },
    (err) => {
      if (err) {
        console.error("[engine] BrowserSync failed:", err);
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

  if (bs.active) {
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
