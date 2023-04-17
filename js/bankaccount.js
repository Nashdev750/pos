const card = document.querySelector('#card'),
    btn = document.querySelector('#f2'),
    nam = document.querySelector('#name'),
    err = document.querySelector('#err')
let edt = 0

function edit(id) {
    edt = id
    fetch(`core/loadaccount.php?edit=${id}`)
        .then(res => res.json())
        .then(data => {

            card.elements['name'].value = data.bankname
            card.elements['number'].value = data.accountnumber
            card.elements['account'].value = data.accountname
            card.elements['note'].value = data.note
            document.querySelector('.pop').classList.add('sho')
            document.querySelector('.popbody').classList.add('sh')
            console.log(data)

        })
}

btn.addEventListener('click', () => {
    if (nam.value == "") {
        err.classList.add('alert-danger')
        err.innerText = "Bank Name is required"
        setTimeout(() => {
            err.classList.remove('alert-danger')
            err.innerText = ""
        }, 3000);
    } else {
        fetch(`core/loadaccount.php?add=${edt}`, {
                method: "POST",
                body: new FormData(card)
            })
            .then(res => res.text())
            .then(data => {

                if (Number(data) > 0) {
                    err.classList.add('alert-success')
                    err.innerText = "Account added"
                    setTimeout(() => {
                        err.classList.remove('alert-success')
                        err.innerText = ""
                    }, 3000);
                    card.reset()
                    loadaccounts();
                } else {
                    err.classList.add('alert-danger')
                    err.innerText = "Server error"
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

    let de = confirm("Delete this item?")
    if (de) {
        fetch(`core/loadaccount.php?delete=${id}`)
            .then(res => res.text())
            .then(data => {
                console.log(data)
                loadaccounts()
            })
    }
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

function format(d) {

    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td>Note:</td>' +
        '<td>' + d.note + '</td>' +
        '</tr>' +


        '</table>';
}

$(document).ready(function() {
    loadaccounts();
});

function loadaccounts() {


    $('#datat').DataTable().clear().destroy();
    var table = $('#datat').DataTable({
        "ajax": {
            'url': 'core/loadaccount.php?load=1'
        },
        "columns": [{
                "className": 'details-control plus',
                "orderable": false,
                "data": 'id',
                "defaultContent": ''
            },

            { "data": "bankname" },
            { "data": "accountnumber" },
            { "data": "accountname" },
            { "data": "col" },
            { "data": "real" },
            { "data": "order" },
            { "data": "act" }
        ],
        "order": [
            [1, 'asc']
        ]
    });

    $('#datat tbody').on('click', 'td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        $('td.details-control').removeClass('active')
        $('tr').removeClass('shown');
        if (row.child.isShown()) {
            // This row is already open - close it
            $(this).removeClass('active')
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            $(this).addClass('active')
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });
}