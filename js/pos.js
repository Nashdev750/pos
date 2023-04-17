const card = document.querySelector('#card'),
    dat = document.querySelector('#dat'),
    btn = document.querySelector('#f2'),
    nam = document.querySelector('#name'),
    err = document.querySelector('#err'),
    cardtype = document.querySelector('#cardtype'),
    fee = document.querySelector('#fee'),
    addc = document.querySelector('#addc'),
    cards = document.querySelector('#cards')
let edt = 0;

addc.addEventListener('click', () => {
    if (cardtype.value == "" || fee.value == "") {
        err.classList.add('alert-danger')
        err.innerText = "Loại thẻ và phí là bắt buộc!"
        setTimeout(() => {
            err.classList.remove('alert-danger')
            err.innerText = ""
        }, 3000);
    } else {
        fetch('core/pos.php?addcard=1', {
                method: "POST",
                body: new FormData(dat)
            })
            .then(res => res.json())
            .then(data => {
                console.log(data)
                dat.reset()
                filtable(data)
            })
    }
})

function filtable(data) {
    let count = 0;
    let h = ''
    data.forEach(card => {
        h += `
        <tr>
        <td>${card.cardtype}</td>
        <td>${card.fee}</td>
        <td onclick ="return remove(${count})"><i class="fa fa-trash"></i></td>
    </tr>`
        count++
    })
    cards.innerHTML = h
}

function remove(c) {
    let de = confirm('Delete this item?')
    if (de) {
        fetch(`core/pos.php?index=${c}`)
            .then(re => re.json())
            .then(data => {
                console.log(data)
                filtable(data);

            })
    }

}

btn.addEventListener('click', () => {
    if (nam.value == "") {
        err.classList.add('alert-danger')
        err.innerText = "Tên POS là bắt buộc!"
        setTimeout(() => {
            err.classList.remove('alert-danger')
            err.innerText = ""
        }, 3000);
    } else {
        fetch(`core/pos.php?add=${edt}`, {
                method: "POST",
                body: new FormData(card)
            })
            .then(res => res.text())
            .then(data => {
                console.log(data)
                if (Number(data) > 0) {
                    err.classList.add('alert-success')
                    err.innerText = "POS đã thêm"
                    card.reset()
                    setTimeout(() => {
                        err.classList.remove('alert-success')
                        err.innerText = ""
                    }, 3000);
                    loadaccounts();
                } else {
                    err.classList.add('alert-danger')
                    err.innerText = "Server lỗi"
                    setTimeout(() => {
                        err.classList.remove('alert-danger')
                        err.innerText = ""
                    }, 3000);
                }
            })
        edt = 0
    }
})





function delet(id) {
    let de = confirm("Xóa mục này?")
    if (de) {
        fetch(`core/pos.php?delete=${id}`)
            .then(res => res.text())
            .then(data => {
                console.log(data)
                loadaccounts()
            })
    }

}

function edit(id) {
    edt = id
    fetch(`core/pos.php?edit=${id}`)
        .then(res => res.json())
        .then(data => {


            card.elements['name'].value = data.posname
            card.elements['account'].value = data.account
            card.elements['note'].value = data.note
            filtable(data.data)
            document.querySelector('.pop').classList.add('sho')
            document.querySelector('.popbody').classList.add('sh')

        })


}

document.querySelectorAll('.clse').forEach(cl => cl.addEventListener('click', () => {
    document.querySelector('.pop').classList.remove('sho')
    document.querySelector('.popbody').classList.remove('sh')


}))


function showmodal() {
    if (document.querySelector('.pop').classList == 'pop') {
        document.querySelector('.pop').classList.add('sho')
        document.querySelector('.popbody').classList.add('sh')
    } else {
        document.querySelector('.pop').classList.remove('sho')
        document.querySelector('.popbody').classList.remove('sh')

    }

}



$(document).ready(function() {
    loadaccounts();
});

function loadaccounts() {


    $('#datat').DataTable().clear().destroy();
    var table = $('#datat').DataTable({
        "ajax": {
            'url': 'core/pos.php?load=1'
        },
        "columns": [{

                "orderable": false,
                "data": "id"

            },

            { "data": "posname" },
            { "data": "account" },
            { "data": "note" },
            { "data": "act" }
        ],
        "order": [
            [1, 'asc']
        ]
    });
    // 'id'=>$item['id'],
    // 'posname'=>$item['posname'],
    // 'account'=>$item['account'],
    // 'note'=>$item['note'],
    // $('#datat tbody').on('click', 'td.details-control', function() {
    //     var tr = $(this).closest('tr');
    //     var row = table.row(tr);
    //     $('td.details-control').removeClass('active')
    //     $('tr').removeClass('shown');
    //     if (row.child.isShown()) {
    //         // This row is already open - close it
    //         $(this).removeClass('active')
    //         row.child.hide();
    //         tr.removeClass('shown');
    //     } else {
    //         // Open this row
    //         $(this).addClass('active')
    //         row.child(format(row.data())).show();
    //         tr.addClass('shown');
    //     }
    // });
}