// settings.js
const initialize = (app) => {
    app.provide('PAGE_LOGIN', {
        background1: 'url(login_bgimg.jpg) center/cover no-repeat fixed',// 大背景
        background2: 'url(login_bgimg.jpg) center/cover no-repeat fixed',// 小背景（操作框）

    });
}

export default initialize;