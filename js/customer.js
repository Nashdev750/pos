const card = document.querySelector('#card')
const f1 = document.querySelector('#f1')
const n2 = document.querySelector('#n2')
const err = document.querySelector('#err')
const details = document.querySelector('#cdetails')
const n = document.querySelector('#n')
const f2 = document.querySelector('#f2')


let cid = 0;

function edit(id) {
    cid = id
    if (id) {
        fetch(`core/customer.php?pr=${id}`)
            .then(res => res.json())
            .then(data => {
                details.elements['name'].value = data.fullname
                details.elements['number'].value = data.phone
                details.elements['adres'].value = data.address
                details.elements['note'].value = data.note
                fetch(`core/customer.php?g=${id}`)
                    .then(res => res.json())
                    .then(data => {
                        let htm = ''
                        let count = 0
                        data.forEach(card => {
                            //`number`, `name`, `bank`, `sdate`, `note`,
                            htm += `
                      <tr id='tds'>
                      <td contenteditable='true' data-ind="${count}" data-c="name" data-id="${card.id}">${card.name}</td>
                      <td contenteditable='true' data-ind="${count}" data-c="bank" data-id="${card.id}">${card.bank}</td>
                      <td contenteditable='true' data-ind="${count}" data-c="number" data-id="${card.id}">${card.number}</td>
                      <td contenteditable='true' data-ind="${count}" data-c="date" data-id="${card.id}">${card.date}</td>
                      <td contenteditable='true' data-ind="${count}" data-c="note" data-id="${card.id}">${card.note}</td>
                      <td>${card.file}</td>
                      <td onclick ="return remov(${count})"><i class="fa fa-trash"></i></td>
                    </tr>`
                            count++
                        });
                        document.querySelector('#rows').innerHTML = htm
                        document.querySelectorAll('#tds td').forEach(td => td.addEventListener('keyup', savechng));

                    })


                document.querySelector('.pop').classList.add('sho')
                document.querySelector('.popbody').classList.add('sh')
            })
    } else {
        alert('customer id not found')
    }
}

function savechng() {
    fetch(`core/customer.php?ecard=${this.dataset.ind}&t=${this.innerText}&col=${this.dataset.c}&id=${this.dataset.id}`)
        .then(res => res.text())
        .then(data => {
            console.log(data)
        })
}

f2.addEventListener('click', () => {
    if (n.value == "") {
        n.style.border = "1px solid tomato !important"
        err.classList.add('alert-danger')
        err.innerText = "Tên khách hàng là bắt buộc!"
        setTimeout(() => {
            err.classList.remove('alert-danger')
            err.innerText = ""
        }, 3000);
    } else {
        addc()
    }
})

function addc() {
    let url = `core/customer.php?cust=0`;
    if (cid != 0) {
        url = `core/customer.php?cust=${cid}`

    }
    fetch(url, {
            method: "POST",
            body: new FormData(details)
        }).then(res => res.text())
        .then(data => {
            console.log(data)
            if (data > 0) {
                details.reset()
                card.reset()
                err.classList.add('alert-success')
                err.innerText = "Đã thêm khách hàng"
                document.querySelector('#rows').innerHTML = ''
                setTimeout(() => {
                    err.classList.remove('alert-success')
                    err.innerText = ""
                }, 3000);
                cid = 0
            } else {
                err.classList.add('alert-danger')
                err.innerText = "Lỗi server"
                setTimeout(() => {
                    err.classList.remove('alert-danger')
                    err.innerText = ""
                }, 3000);

            }
        })

}
f1.addEventListener('click', () => {
    if (n2.value == "") {
        n2.style.border = "1px solid tomato !important"
        err.classList.add('alert-danger')
        err.innerText = "Nhập tên thẻ"
        setTimeout(() => {
            err.classList.remove('alert-danger')
            err.innerText = ""
        }, 3000);
    } else {
        add()
    }
})

function add() {
    fetch(`core/customer.php?card=1`, {
            method: "POST",
            body: new FormData(card)

        })
        .then(res => res.json())
        .then(data => {
            console.log(data)
            table(data)
            card.reset()
        })
}

function table(data) {
    let htm = ''
    let count = 0
    data.forEach(card => {
        htm += `
  <tr>
  <td>${card.name}</td>
  <td>${card.bank}</td>
  <td>${card.number}</td>
  <td>${card.date}</td>
  <td>${card.note}</td>
  <td>${card.file}</td>
  <td onclick ="return remov(${count})"><i class="fa fa-trash"></i></td>
</tr>`
        count++
    });
    document.querySelector('#rows').innerHTML = htm
}

function load(key) {

}

function remov(id) {
    let d = confirm("Xóa mục này!")
    if (d) {
        fetch(`core/customer.php?del=${id}`)
            .then(res => res.json())
            .then(data => {
                table(data)
            })
    }

}



function remove(id) {
    let d = confirm("Xác nhận xóa!")
    if (d) {
        fetch(`core/customer.php?d=${id}`)
            .then(res => res.text())
            .then(data => {
                loadtab()
            })
    }

}

document.querySelectorAll('.clse').forEach(cl => cl.addEventListener('click', () => {
    document.querySelector('.pop').classList.remove('sho')
    document.querySelector('.popbody').classList.remove('sh')
    details.reset()
    card.reset()
    document.querySelector('#rows').innerHTML = ''
    loadtab()
    seskill()
}))


function showmodal() {
    if (document.querySelector('.pop').classList == 'pop') {
        document.querySelector('.pop').classList.add('sho')
        document.querySelector('.popbody').classList.add('sh')
    } else {
        document.querySelector('.pop').classList.remove('sho')
        document.querySelector('.popbody').classList.remove('sh')
        loadtab()
        seskill()
    }

}
loadtab()


//`fullname`, `phone`, `address`, `debt`, `note`, `pubat`,
// $('#datat').DataTable().clear().destroy();

function loadtab() {
    $('#datat').DataTable().clear().destroy();
    var table = $('#datat').DataTable({
        "ajax": {
            'url': 'core/customer.php?loadc'
        },
        "columns": [

            { "data": "id" },
            { "data": "fullname" },
            { "data": "phone" },
            { "data": "address" },
            { "data": "debt" },
            { "data": "note" },
            { "data": "pubat" },
            { "data": "act" }
        ],
        "order": [
            [7, 'desc']
        ]
    });
}

function seskill() {
    fetch(`core/customer.php?kill`)
        .then(res => res.text())
        .then(data => {

        })
}