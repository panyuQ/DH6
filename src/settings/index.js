// settings.js

const initialize = async (app) => {
    app.provide('PAGE_LOGIN', {
        background1: 'url(login_bgimg.jpg) center/cover no-repeat fixed',// 大背景
        background2: 'url(login_bgimg.jpg) center/cover no-repeat fixed',// 小背景（操作框）
    });
    app.provide('PAGE_HOME', {
        aside: {
            width: '300px',
        }
    });

    // 动态加载 package.json
    app.provide('APP', await import('../../package.json'));
}

export default initialize;