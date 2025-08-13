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
    

// Active link functionality - run after everything is loaded
function setActiveLink() {
  console.log("Setting active link...");
  
  // Get current page filename
  let pathname = window.location.pathname;
  let currentPage = pathname.split('/').pop() || 'index.html';
  
  console.log("Pathname:", pathname);
  console.log("Current page:", currentPage);
  
  // Remove all active classes first
  document.querySelectorAll('.nav-links a').forEach(link => {
    link.classList.remove('active');
  });
  
  // Find the matching link and add active class
  document.querySelectorAll('.nav-links a').forEach(link => {
    let href = link.getAttribute('href');
    console.log("Checking link:", href);
    
    if (href === currentPage) {
      console.log("Found match! Making active:", href);
      link.classList.add('active');
    }
  });
  
  // Special case for home page
  if (currentPage === '' || currentPage === 'index.html' || pathname === '/') {
    const homeLink = document.querySelector('.nav-links a[href="index.html"]');
    if (homeLink) {
      console.log("Setting home link as active");
      homeLink.classList.add('active');
    }
  }
}

// Run when DOM is ready
document.addEventListener("DOMContentLoaded", function () {
  // Small delay to ensure everything is loaded
  setTimeout(setActiveLink, 100);
});

// Also run when window is fully loaded
window.addEventListener("load", function () {
  setActiveLink();
});
