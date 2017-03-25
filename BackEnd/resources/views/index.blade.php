<!DOCTYPE html><html><head><meta charset=utf-8><title>gold-miner-web</title><link rel="shortcut icon" href=//gold-cdn.xitu.io/favicons/favicon.ico><link href=/static/css/app.08f2089fa72012afd654445defe7f8aa.css rel=stylesheet></head><body><div id=app></div><script>const parse = function (search) {
        const arr = search.split('&')
        const result = {}

        arr.map((item) => {
          const params = item.split('=')
          result[params[0]] = params[1]
        })

        return result
      }

      const params = parse(location.search.substring(1))

      if (params.login) {
        const user = JSON.stringify({
          id: 1,
          username: '根号三',
          avatar: '/static/avatar.png',
          authentication: false,
          rule: ['admin'],
        })

        localStorage.setItem('user', user)
        location.href = '/'
      }

      if (params.logout) {
        localStorage.removeItem('user')
        location.href = '/'
      }

      window.__USER__ = localStorage.getItem('user')</script><script type=text/javascript src=/static/js/manifest.38e17992c42dd23e8175.js></script><script type=text/javascript src=/static/js/vendor.de49ffb49d03ccd2f886.js></script><script type=text/javascript src=/static/js/app.15ba82d35f9d1594da0c.js></script></body></html>