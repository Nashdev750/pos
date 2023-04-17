const save = document.querySelector('#save')
const rev = document.querySelector('#rev')
const account = document.querySelector('#account')
const amount = document.querySelector('#amount')
const inamount = document.querySelector('#inamount')
const qty = document.querySelector('#qty')
const err = document.querySelector('#err')
const clv = document.querySelectorAll('.clv')
let fm = Intl.NumberFormat('en-US')
let edt = 0;


clv.forEach((cl) => {
    var cleave = new Cleave(cl, {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
    });
})
amount.addEventListener('keyup', calc)
qty.addEventListener('keyup', calc)

function calc() {
    let a = Number(amount.value.replace(/,/g, '')) * Number(qty.value.replace(/,/g, ''))
    inamount.value = fm.format(a)
}
save.addEventListener('click', () => {
    if (account.value == "" || amount.value == "") {
        err.classList.add('alert-danger')
        err.innerText = "Tài khoản và khoản tiền là bắt buộc!"
        setTimeout(() => {
            err.classList.remove('alert-danger')
            err.innerText = ""
        }, 3000);
    } else {
        fetch(`core/collect.php?in=0&id=${edt}`, {
                method: "POST",
                body: new FormData(rev)
            })
            .then(res => res.text())
            .then(data => {
                console.log(data)
                if (Number(data) > 0 || edt > 0) {
                    err.classList.add('alert-success')
                    err.innerText = "Hoạt động thành công"
                    setTimeout(() => {
                        err.classList.remove('alert-success')
                        err.innerText = ""
                        edt = 0
                    }, 3000);
                }
            })
    }
})

document.querySelectorAll('.clse').forEach(cl => cl.addEventListener('click', () => {
    document.querySelector('.pop').classList.remove('sho')
    document.querySelector('.popbody').classList.remove('sh')
    location.reload()
}))


function showmodal() {
    if (document.querySelector('.pop').classList == 'pop') {
        document.querySelector('.pop').classList.add('sho')
        document.querySelector('.popbody').classList.add('sh')
    } else {
        document.querySelector('.pop').classList.remove('sho')
        document.querySelector('.popbody').classList.remove('sh')
        location.reload()
    }

}

function remove(id) {

    let c = confirm("Xóa mục này?")
    if (c) {
        fetch(`core/collect.php?del=${id}`)
            .then(res => res.text())
            .then(data => {
                location.reload()
            })
    }
}

function edit(id) {
    edt = id
    fetch(`core/collect.php?edit=${id}`)
        .then(res => res.json())
        .then(data => {
            let q = Number(data.amount.replace(/,/g, '')) * Number(data.quantity.replace(/,/g, ''))
            if (Number(data.status) == 1) {
                document.querySelector('#collect').checked = true
            } else {
                document.querySelector('#spend').checked = true
            }
            //`id`, `account`, `amount`, `quantity`, `day`, `note`, `status`
            rev.elements['amount'].value = data.amount
            rev.elements['day'].value = data.day
            rev.elements['account'].value = data.account
            rev.elements['qty'].value = data.quantity
            rev.elements['note'].value = data.note
            rev.elements['inamount'].value = fm.format(Math.round(q))
            document.querySelector('.pop').classList.add('sho')
            document.querySelector('.popbody').classList.add('sh')
        })
}