const tabs = document.querySelectorAll('.tabs__title');

if (tabs) {
  tabs.forEach(tab => {
    tab.addEventListener('click', e => {
      const tabName = e.target.dataset.tab;
      const tabsContainer = e.target.closest('.tabs');

      const tabsTitles = tabsContainer.querySelectorAll('.tabs__title');
      tabsTitles.forEach(tabTitle => {
        if (tabTitle === e.target) {
          tabTitle.classList.add('tabs__title-active');
        } else if (tabTitle.classList.contains('tabs__title-active')) {
          tabTitle.classList.remove('tabs__title-active');
        }
      });

      const tabsItem = tabsContainer.querySelectorAll('.tabs__body');
      tabsItem.forEach(tabItem => {
        if (tabItem.getAttribute('data-tab-name') === tabName) {
          tabItem.classList.add('tabs__body-active');
        } else if (tabItem.classList.contains('tabs__body-active')) {
          tabItem.classList.remove('tabs__body-active');
        }
      });
    });
  });
}
