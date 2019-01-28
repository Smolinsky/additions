    var usr = "";

    function loadinfo() {
        var github_users = new XMLHttpRequest();
        github_users.open('GET', 'https://api.github.com/users', false);
        github_users.send();
        var user = github_users.responseText;
        user = JSON.parse(user);
        var header = '<h2>Юзери Github</h2>';
        var list_users = '';
        var usr = '';
        for (var username in user) {
            usr = user[username].login;  
            list_users += '<li>' + user[username].login + '<br>' + "<img src='" + user[username].avatar_url + "'>" + '<br>' + '<button class="show" onclick=" followers(\'' + usr + '\')">Показати підписників</button>' + '<br><br>' + '</li>';
        }
        document.getElementById('users').innerHTML = '';
        document.getElementById('head').innerHTML = '';
        document.getElementById('head').innerHTML += header;
        document.getElementById('users').innerHTML += '<ul>' + list_users + '</ul>';
    }

    function followers(usr) {
        var github_userses = new XMLHttpRequest();
        github_userses.open('GET', 'https://api.github.com/users/' + usr + '/followers', false);
        github_userses.send();
        var users = github_userses.responseText;
        users = JSON.parse(users);
        var headers = '<h2>Підписники ' + usr + '</h2>';
        var list_users1 = '';

        for (var link in users) {
            list_users1 += '<li>' + '<img src="' + users[link].avatar_url + '" alt="ava" />' + '<p class="name">' + users[link].login + '</p>' + '</li>';
        }

        document.getElementById('users').innerHTML = '';
        document.getElementById('head').innerHTML = '';
        document.getElementById('head').innerHTML += headers;
        document.getElementById('users').innerHTML += '<ul>' + list_users1 + '</ul>';
    }
