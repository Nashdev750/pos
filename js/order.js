const order = document.querySelector('#order'),
    errorpop = document.querySelector('.errorpop'),
    customer = document.querySelector("#customer"),
    selectedcard = document.querySelector("#selectedcard"),
    total = document.querySelector("#total"),
    remaining = document.querySelector("#remaining"),
    deposit = document.querySelector("#deposit"),
    withdrawal = document.querySelector("#withdrawal"),
    bankfee = document.querySelector("#bankfee"),
    collectionfee = document.querySelector("#collectionfee"),
    shippingfee = document.querySelector("#shippingfee"),
    charge = document.querySelector("#charge"),
    realfood = document.querySelector("#realfood"),
    profit = document.querySelector("#profit"),
    orderdate = document.querySelector("#orderdate"),
    note = document.querySelector("#note"),
    save = document.querySelectorAll("#comfirm"),

    // deposit
    depo = document.querySelector('#depo'),
    damount = document.querySelector('#damount'),
    daccount = document.querySelector('#daccount'),
    ddate = document.querySelector('#ddate'),
    dnote = document.querySelector('#dnote'),
    rows1d = document.querySelector('#rows1d'),
    fdeposit = document.querySelector('#fdeposit'),
    // post
    post = document.querySelector('#post'),
    pbtn = document.querySelector('#pbtn'),
    ppos = document.querySelector('#ppos'),
    ptype = document.querySelector('#ptype'),
    rows2p = document.querySelector('#rows2p'),
    pamount = document.querySelector('#pamount'),
    psmallfee = document.querySelector('#psmallfee'),
    // real food
    real = document.querySelector('#real'),
    realbtn = document.querySelector('#realbtn'),
    realc = document.querySelector('#realc'),
    rows3re = document.querySelector('#rows3re'),
    expire = document.querySelector('#expire'),
    other = document.querySelector('#other'),
    tt = document.querySelector('#tt'),
    w = document.querySelector('.w'),
    mustreturn = document.querySelector('#mustreturn'),
    paid = document.querySelector('#paid'),
    remain = document.querySelector('#remain'),
    clv = document.querySelectorAll('.clv')
let url = 'core/fetchorder.php?load=1'
let oid = 0;
let flag = (expire.checked) ? 0 : 1;
let fm = Intl.NumberFormat('en-US')
clv.forEach((cl) => {
    var cleave = new Cleave(cl, {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
    });
})

ptype.addEventListener('change', () => {
    if (ptype.value != "") {
        pamount.removeAttribute('readonly')
    } else {
        pamount.setAttribute('readonly', 'true')
    }

})
ppos.addEventListener('change', loadtype)
ptype.addEventListener('change', calcsmf)
pamount.addEventListener('keyup', calcsmf)

function calcsmf() {
    let s = Math.round((Number(ptype.value.split('-')[1].replace(/,/g, '')) / 100) * Number(pamount.value.replace(/,/g, '')))
    psmallfee.value = fm.format(s)
}


function loadtype() {
    let op = document.querySelectorAll(`#id_${this.value.replace(/,/g,'')}`)
    op.forEach(opt => opt.classList.add('dds'))
}



expire.addEventListener('click', () => {
    tt.innerText = "Tổng tiền phải làm"
    w.classList.add('d')
    total.removeAttribute('readonly')

    flag = 0
})
other.addEventListener('click', () => {
    tt.innerText = "Tổng tiền trả"
    w.classList.remove('d')
    total.setAttribute('readonly', 'true')
    flag = 1
})

function showmodal(id, cid, name, cna) {

    document.querySelector('#newtest2').innerHTML = `
                   <label>Khách hàng </label>
                   <select name="" class="form-control" readonly> 
                       <option value="${name}(${id})" selected>${name} </option>           
                    </select>`

    document.querySelector('#newtest').innerHTML = `
                    <label>Thẻ</label>
                    <select name="" class="form-control" readonly> 
                        <option value="${cna}(${cid})" selected>${cna} </option>           
                     </select>`
    selectedcard.value = `${id}`
        // selectedcard.attribute.value = id

    customer.value = `${cid}`
        //customer.attribute.value = cid

    if (document.querySelector('.pop').classList == 'pop') {
        document.querySelector('.pop').classList.add('sho')
        document.querySelector('.popbody').classList.add('sh')
    } else {
        document.querySelector('.pop').classList.remove('sho')
        document.querySelector('.popbody').classList.remove('sh')
        load("")
    }

}

total.addEventListener('keyup', calcremain)
deposit.addEventListener('keyup', calcremain)


function calcremain() {


    let rem = Number(total.value.replace(/,/g, '')) - Number(deposit.value.replace(/,/g, ""));
    remaining.value = fm.format(Math.round(rem)).toString()
}

collectionfee.addEventListener('keyup', chargec)
withdrawal.addEventListener('keyup', chargec)

function chargec() {
    let c = (Number(collectionfee.value.replace(/,/g, '')) / 100) * Number(withdrawal.value.replace(/,/g, ''));
    charge.value = fm.format(Math.round(c))
    profit.value = fm.format(Math.round(Number(charge.value.replace(/,/g, "")) - Number(bankfee.value.replace(/,/g, ''))))

    calcfd()

}

function showerror(message, color) {
    if (color == 1) {
        errorpop.querySelector('span').style.color = "green"
        errorpop.style.background = "#10ca93"
    }
    errorpop.querySelector('span').innerText = message;
    errorpop.classList.add('erroract')

    setTimeout(() => {
        errorpop.querySelector('span').style.color = "red"
        errorpop.style.background = "#F5D2D2"
        errorpop.classList.remove('erroract')
    }, 3000);
}
fdeposit.addEventListener('click', depositcash)

function depositcash() {
    if (daccount.value == "") {
        showerror('Please select account', 'color')
    } else {
        fetch(`core/order?deposit`, {
                method: "POST",
                body: new FormData(depo)
            })
            .then(res => res.json())
            .then(data => {
                loaddpo(data)
            })
    }
}
pbtn.addEventListener('click', postcash)

function postcash() {
    if (ppos.value == "") {
        showerror('Please select POS', 'color')
    } else if (ptype.value == "") {
        showerror('Please select POS type ', 'color')
    } else if (pamount.value == "") {
        showerror('Enter Amount', 'color')
    } else {
        fetch(`core/order?post`, {
                method: "POST",
                body: new FormData(post)
            })
            .then(res => res.json())
            .then(data => {
                loadpost(data)
            })
    }
}
realbtn.addEventListener('click', foodcash)

function foodcash() {
    if (realc.value == "") {
        showerror('Please select real account', 'color')
    } else {
        fetch(`core/order?food`, {
                method: "POST",
                body: new FormData(real)
            })
            .then(res => res.json())
            .then(data => {
                loadfood(data)
            })
    }
}

function remove(i, req) {
    fetch(`core/order.php?${req}=${i}`)
        .then(res => res.json())
        .then(data => {
            console.log(data)
            if (req == "rdepo") {
                loaddpo(data)
            } else if (req == "rfood") {
                loadfood(data)
            } else {
                loadpost(data)
            }
        })
}

function resetses() {
    // let sel = document.querySelectorAll('select')
    // sel.forEach(se => sel.selectedIndex = -1)
    real.reset()
    post.reset()
    depo.reset()
    rows1d.innerHTML, rows2p.innerHTML, rows3re.innerHTML = ""
    fetch(`core/order.php?reset`)
        .then(res => res.text())
        .then(data => {})
}

document.querySelectorAll('.clse').forEach(cl => cl.addEventListener('click', () => {
    resetses()
    let flg = document.querySelector('body').dataset.page;
    if (flg == "order") {
        loadorder(url)
    }
    flag = 0
    document.querySelector('.pop').classList.remove('sho')
    document.querySelector('.popbody').classList.remove('sh')

}))

function loaddpo(data) {
    let h = ''
    let i = 0
    let d = 0
    console.log(data)
    data.forEach(inf => {
        h += `
        <tr>
        <th>${inf.accountname}</th>
        <th>${inf.amount}</th>
        <th>${inf.orderdate}</th>
        <th>${inf.note}</th>
       
        <td onclick ="return remove(${i},'rdepo')"><i class="fa fa-trash"></i></td>
        </tr>
        `
        console.log(inf.amount.replace(/,/g, ''))
        d += Math.round(Number(inf.amount.replace(/,/g, '')))
        i++
    });

    depo.reset()

    deposit.value = null

    deposit.value = fm.format(d)
    paid.value = fm.format(d)
    let rem = Number(total.value.replace(/,/g, '')) - d;
    remaining.value = fm.format(rem)
    console.log("remainig =" + rem)
    flag = (expire.checked) ? 0 : 1;
    if (flag == 1) {
        total.value = fm.format(d)
        totalremaining()
    }
    rows1d.innerHTML = h;
    calcfd()
}

function loadpost(data) {
    let h = ''
    let i = 0;
    let w = 0;
    let s = 0
    data.forEach(inf => {
        h += `
        <tr>
        <th>${inf.postname}</th>
        <th>${inf.posttype}%</th>
        <th>${inf.amount}</th>
        <th>${inf.smallfee}</th>
        <th>${(Number(inf.moneystatus)==1)?"Come back":"Haven't come back"}</th>
        <th>${inf.swipeday}</th>
        <th>${inf.backday}</th>
        <th>${inf.note}</th>
        <td onclick ="return remove(${i},'rpost')"><i class="fa fa-trash"></i></td>
        </tr>
        `
        w += Math.round(Number(inf.amount.replace(/,/g, '')))
        s += Math.round(Number(inf.smallfee.replace(/,/g, '')))

        i++
    });

    post.reset()
    let chrg = Math.round((w * (Number(collectionfee.value.replace(/,/g, '')) / 100)));
    bankfee.value = fm.format(s);
    charge.value = fm.format(chrg)
    withdrawal.value = ""
    withdrawal.value = fm.format(w)
    rows2p.innerHTML = h
    let r = w - Number(shippingfee.value.replace(/,/g, ''))
    mustreturn.value = fm.format(r)
    profit.value = fm.format(Math.round(Number(charge.value.replace(/,/g, "")) - Number(bankfee.value.replace(/,/g, ''))))
    flag = (expire.checked) ? 0 : 1;
    if (flag == 1) {

        totalremaining()
    }
    calcfd()
}

function calcfd() {
    let food = Number(deposit.value.replace(/,/g, '')) - Number(withdrawal.value.replace(/,/g, '')) + Number(charge.value.replace(/,/g, '')) + Number(shippingfee.value.replace(/,/g, ''))
    flag = (expire.checked) ? 0 : 1;
    if (flag == 1) {
        food = Number(deposit.value.replace(/,/g, '')) - Number(withdrawal.value.replace(/,/g, '')) + Number(shippingfee.value.replace(/,/g, ''))
    }
    realfood.value = fm.format(food);
}

function loadfood(data) {
    let h = ''
    let i = 0
    let food = 0
    data.forEach(inf => {
        h += `
        <tr>
        <th>${inf.accountname}</th> 
        <th>${inf.amount}</th>
        <th>${inf.day}</th>
        <th>${inf.note}</th>
       
        <td onclick ="return remove(${i},'rfood')"><i class="fa fa-trash"></i></td>
        </tr>
        `
        food += Math.round(Number(inf.amount.replace(/,/g, '')))
        i++
    });
    real.reset()

    rows3re.innerHTML = h
}
save.forEach(el => el.addEventListener('click', subm))

function subm() {
    flag = (expire.checked) ? 0 : 1;
    let id = this.dataset.id;

    if (oid != 0) {
        id = oid;
    }


    fetch(`core/order.php?action=${flag}&id=${id}`, {
            method: "POST",
            body: new FormData(order)
        })
        .then(res => res.text())
        .then(data => {
            console.log(data)
            if (Number(data) > 0) {
                resetses()
                showerror('Order Created!', 1)
            } else {
                resetses()
                showerror('Operation compete!', 1)
            }

        })
}


function totalremaining() {
    let tot = Number(withdrawal.value.replace(/,/g, '')) - Number(total.value.replace(/,/g, '')) - Number(shippingfee.value.replace(/,/g, ''))
    remaining.value = fm.format(Math.round(tot)).toString()
}
shippingfee.addEventListener('keyup', () => {
        let r = Number(withdrawal.value.replace(/,/g, '')) - Number(shippingfee.value.replace(/,/g, ''))
        mustreturn.value = fm.format(r)
        let rem = r - Number(paid.value.replace(/,/g, ''));
        remain.value = fm.format(rem)
        calcfd()
    })
    // edit order


// 'id'=>$o['id'],
// 'custmer'=> $c,
// 'card'=> $cd,
// 'total'=>$o['total'],
// 'deposit'=>$o['deposit'],
// 'withdrawal'=>$o['withdrawal'],
// 'collection_fee'=>$o['collection_fee'],
// 'food'=>$o['food'],
// 'order_date'=>$o['order_date'],
// 'note'=>$o['note'],
// 'type'=>$o['type'] 
function editorder(id) {
    oid = Number(id)
    if (id) {

        fetch(`core/fetchorder.php?edit=${id}`)
            .then(res => res.json())
            .then(data => {
                console.log(data)
                document.querySelector('#newtest2').innerHTML = `
                <label>Khách hàng </label>
                <select name="" class="form-control" readonly> 
                    <option selected>${data.custmer.fullname} </option>           
                 </select>`

                document.querySelector('#newtest').innerHTML = `
                 <label>Thẻ</label>
                 <select name="" class="form-control" readonly> 
                     <option selected>${data.card.name ? data.card.name: "card"} </option>           
                  </select>`
                customer.value = data.custmer.id
                selectedcard.value = data.card.id
                total.value = data.total
                deposit.value = data.deposit
                withdrawal.value = data.withdrawal
                collectionfee.value = data.collection_fee
                shippingfee.value = data.ship
                orderdate.value = data.order_date
                note.value = data.note
                flag = Number(data.type)
                if (flag == 1) {
                    tt.innerText = "Total Amount Paid"
                    w.classList.remove('d')
                    other.checked = true
                    total.setAttribute('readonly', 'true')
                } else {
                    flag = 0;
                    tt.innerText = "Total Money to do"
                    w.classList.add('d')
                    expire.checked = true
                    total.removeAttribute('readonly')
                }
                data1().then(data => {
                    loadpost(data)
                })

                // console.log(dta)
                // fetch(`core/fetchorder?post`)
                //     .then(res => res.json())
                //     .then(data => {

                //     })
                fetch(`core/fetchorder?deposit`)
                    .then(res => res.json())
                    .then(data => {
                        loaddpo(data)
                    })
                fetch(`core/fetchorder?food`)
                    .then(res => res.json())
                    .then(data => {
                        loadfood(data)
                    })
                document.querySelector('.pop').classList.add('sho')
                document.querySelector('.popbody').classList.add('sh')

            })
    } else {
        alert("order id not found")
    }
}
document.querySelector('#moneystatus').addEventListener('change', updm);
async function data1() {
    const res = await fetch(`core/fetchorder?post`);
    const data = await res.json()
    return data
}

function updm() {
    if (Number(this.value) == 1) {
        let dat = new Date()
        document.querySelector('#backday').value = `${dat.getFullYear()}-${dat.getMonth()<10?'0'+dat.getMonth():dat.getMonth()}-${dat.getDay()<10?'0'+dat.getDay():dat.getDay()}`
    } else {
        document.querySelector('#backday').value = null
    }
}


// order page
const start = document.querySelector('#start')
const stop = document.querySelector('#stop')
const day = document.querySelector('#day')
const month = document.querySelector('#month')
const client = document.querySelector('#client')
const calender = document.querySelector('#calender')
day.addEventListener('click', () => {
    start.setAttribute('type', 'date')
    stop.setAttribute('type', 'date')

})
month.addEventListener('click', () => {
    start.setAttribute('type', 'month')
    stop.setAttribute('type', 'month')

})
calender.addEventListener('click', () => {
        console.log(client.value)
        if (start.value != "" && stop.value != "") {
            let url = `core/fetchorder.php?load=1&start=${start.value}&stop=${stop.value}&client=${client.value}`
            loadorder(url)
        }

    })
    //   $(document).ready(function(){
    //     $('#datat').DataTable()
    // })
function format(d) {

    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td>Dịch vụ:</td>' +
        '<td>' + d.type + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Ngày tạo đơn:</td>' +
        '<td>' + d.date + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Ngày sao kê:</td>' +
        '<td>' + d.sdate + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Phí bank:</td>' +
        '<td>' + d.bankfee + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Phí ship:</td>' +
        '<td>' + d.ship + '</td>' +
        '</tr>' +

        '</table>';
}

$(document).ready(function() {
    loadorder(url)
});

function delet(id) {
    let ok = confirm("delete this order?")
    if (ok) {
        fetch(`core/fetchorder.php?del=${id}`)
            .then(res => res.text())
            .then(data => {
                location.reload()
            })
    }

}

function loadorder(url) {
    $('#datat').DataTable().clear().destroy();
    var table = $('#datat').DataTable({
        "ajax": {
            'url': url
        },
        "columns": [{
                "className": 'details-control plus',
                "data": 'dd',
                "defaultContent": ''
            },

            { "data": "CLIENT" },
            { "data": "TOTALSEND" },
            { "data": "TOTALDRAW" },
            { "data": "FEES" },
            { "data": "RECEIVABLEDEPRECATE" },
            { "data": "PROFIT" },
            { "data": "COLLECTED" },
            { "data": "DEBT" },
            { "data": "act" }
        ],
        "order": [
            [0, 'desc']
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

function exportdata() {
    fetch(`core/export.php`)
        .then(res => res.text())
        .then(data => {
            console.log(data)
            let a = document.createElement('a')
            a.href = `csv/${data}`
            a.setAttribute('download', `${data}`)
            a.click()
                //location = `csv/${data}`
        })
}