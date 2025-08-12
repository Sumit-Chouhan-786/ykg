    // Mobile menu toggle
    document.querySelector('.menu-toggle').addEventListener('click',()=>{
      document.querySelector('.nav-links').classList.toggle('active');
    });
    
    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(a=>{
      a.addEventListener('click',e=>{
        e.preventDefault();
        const t = document.querySelector(a.getAttribute('href'));
        if(t) window.scrollTo({ top:t.offsetTop-80, behavior:'smooth' });
        document.querySelector('.nav-links').classList.remove('active');
      });
    });
    
    // Tabs
    document.querySelectorAll('.tab-btn').forEach(btn=>{
      btn.addEventListener('click',()=>{
        document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('active'));
        btn.classList.add('active');
        const id = btn.getAttribute('data-tab')+'-content';
        document.querySelectorAll('.tab-content').forEach(c=>c.classList.remove('active'));
        document.getElementById(id).classList.add('active');
      });
    });
    
    // File input display
    const fi = document.getElementById('attachment'),
          fn = document.getElementById('fileName');
    fi.addEventListener('change',()=>{
      fn.textContent = fi.files.length ? fi.files[0].name : 'No file chosen';
    });
    

 const currentPage = window.location.pathname.split("/").pop().toLowerCase();

  document.querySelectorAll(".nav-links a").forEach(link => {
    const linkPage = link.getAttribute("href").toLowerCase();
    if (linkPage === currentPage) {
      link.classList.add("active");
    }
  });