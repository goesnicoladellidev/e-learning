window.onload = function () {
    document.querySelector('.button').addEventListener('click', function () {
        document.querySelector('.container').classList.toggle('invisible');
        this.classList.toggle('mif-chevron-right');
    });
}