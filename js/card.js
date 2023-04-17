const tabs = document.querySelectorAll('.tabs div'),
    cols = document.querySelectorAll('.ts')





function norder(id) {
    let ok = confirm("Xác nhân không order trong tháng này")
    if (ok) {
        fetch(`core/order.php?norder=${id}`)
            .then(res => res.text())
            .then(data => {

                location.reload()
            })
    }
}

tabs.forEach(tab => tab.addEventListener('click', showtab))

function showtab() {
    tabs.forEach(tab => tab.classList.remove('active'))
    this.classList.add('active')
    cols.forEach(tab => tab.classList.remove('act'))
    let i = Number(this.dataset.t)
    cols[i].classList.add('act')

}