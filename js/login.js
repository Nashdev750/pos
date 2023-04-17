const frm = document.querySelector('#frm'),
    btn = document.querySelector('.btn-r'),
    error = document.querySelector('.error')


btn.addEventListener('click', register);

function register() {
    btn.innerText = "Đăng nhập...";
    fetch('core/login.php', {
            method: 'post',
            body: new FormData(frm)
        })
        .then(res => res.text())
        .then(data => {
            btn.innerText = "Đăng nhập";
            if (data == 'access') {
                location.reload();
            } else {
                error.innerHTML = data
                btn.innerText = "Đăng nhập";
            }

        })
}