const btn=document.querySelector('.menu-btn');
const nav=document.querySelector('.nav');
if(btn&&nav){
  btn.addEventListener('click',()=>{
    const open=nav.classList.toggle('open');
    btn.setAttribute('aria-expanded',open?'true':'false');
    document.body.classList.toggle('menu-open',open);
  });
  nav.querySelectorAll('a').forEach(a=>a.addEventListener('click',()=>{
    nav.classList.remove('open');btn.setAttribute('aria-expanded','false');document.body.classList.remove('menu-open');
  }));
}
document.querySelectorAll('[data-year]').forEach(el=>el.textContent=new Date().getFullYear());
const els=document.querySelectorAll('.reveal');
if('IntersectionObserver' in window){
  const io=new IntersectionObserver(entries=>entries.forEach(e=>{if(e.isIntersecting){e.target.classList.add('is-visible');io.unobserve(e.target)}}),{threshold:.1});
  els.forEach(el=>io.observe(el));
}else{els.forEach(el=>el.classList.add('is-visible'))}


// Hero background slider: replace assets/img/hero/hero-1.png, hero-2.png and hero-3.png with your own photos.
const heroSlides=[...document.querySelectorAll('.hero-slide')];
const heroPrev=document.querySelector('.hero-arrow-prev');
const heroNext=document.querySelector('.hero-arrow-next');
if(heroSlides.length>1){
  let heroIndex=0;
  let heroTimer;
  const showHeroSlide=(index)=>{
    heroIndex=(index+heroSlides.length)%heroSlides.length;
    heroSlides.forEach((slide,i)=>slide.classList.toggle('is-active',i===heroIndex));
  };
  const startHeroSlider=()=>{
    clearInterval(heroTimer);
    if(!window.matchMedia('(prefers-reduced-motion: reduce)').matches){
      heroTimer=setInterval(()=>showHeroSlide(heroIndex+1),5500);
    }
  };
  heroPrev?.addEventListener('click',()=>{showHeroSlide(heroIndex-1);startHeroSlider();});
  heroNext?.addEventListener('click',()=>{showHeroSlide(heroIndex+1);startHeroSlider();});
  startHeroSlider();
}
