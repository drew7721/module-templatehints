/**
 * Set a listener for keys `Shift + Ctrl + H` to trigger the display of the hints on the page.
 *
 * @author Alex Ghiban <drew7721@gmail.com>
 **/
(function(){
    document.addEventListener('keydown', function (e) {
        if (e.key === 'H' && e.shiftKey && e.ctrlKey) {
            document.getElementsByTagName('body')[0].classList.toggle('justinkase-hints-enabled');
        }
    })
}());
