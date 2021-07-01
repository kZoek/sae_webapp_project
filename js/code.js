// to top button 
const toTopbtn = document.querySelector('.toTopbtn');

toTopbtn.addEventListener('click',()=>{
    console.log('clicked');
    window.scroll({top:0,left:0, behavior:'smooth'});
});


