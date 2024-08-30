document.addEventListener('DOMContentLoaded', () => {
    console.log('DOMContentLoaded event triggered');
    const themeToggleBtn = document.getElementById('theme-toggle-icon');
    const sunIcon = document.getElementById('sun-icon');
    const moonIcon = document.getElementById('moon-icon');
    const body = document.body;
    const list = document.querySelector('ul'); // 选择ul元素
    const listItems = document.querySelectorAll('li'); // 选择所有li元素

    // Load theme from local storage
    const currentTheme = localStorage.getItem('theme') || 'light';
    body.classList.add(`${currentTheme}-theme`);
    list.classList.add(`${currentTheme}-theme`); // 为ul添加当前主题的类名
    listItems.forEach(li => li.classList.add(`${currentTheme}-theme`)); // 为每个li添加当前主题的类名

    // Set initial icon visibility
    if (currentTheme === 'dark') {
        sunIcon.style.display = 'none';
        moonIcon.style.display = 'inline';
    } else {
        sunIcon.style.display = 'inline';
        moonIcon.style.display = 'none';
    }

    // Toggle theme and icon
    themeToggleBtn.addEventListener('click', () => {
        console.log('Theme toggle button clicked');
        if (body.classList.contains('light-theme')) {
            body.classList.replace('light-theme', 'dark-theme');
            list.classList.replace('light-theme', 'dark-theme'); // 更新ul的类名
            listItems.forEach(li => li.classList.replace('light-theme', 'dark-theme')); // 更新每个li的类名
            sunIcon.style.display = 'none';
            moonIcon.style.display = 'inline';
            localStorage.setItem('theme', 'dark');
        } else {
            body.classList.replace('dark-theme', 'light-theme');
            list.classList.replace('dark-theme', 'light-theme'); // 更新ul的类名
            listItems.forEach(li => li.classList.replace('dark-theme', 'light-theme')); // 更新每个li的类名
            sunIcon.style.display = 'inline';
            moonIcon.style.display = 'none';
            localStorage.setItem('theme', 'light');
        }
    });
});
