function showToast(message) {
  const toast = document.createElement('div');
  toast.innerText = message;
  toast.style.position = 'fixed';
  toast.style.bottom = '30px';
  toast.style.right = '30px';
  toast.style.background = '#6030b9';
  toast.style.color = 'white';
  toast.style.padding = '12px 20px';
  toast.style.borderRadius = '8px';
  toast.style.boxShadow = '0 2px 10px rgba(0,0,0,0.2)';
  toast.style.fontFamily = 'Inter, sans-serif';
  toast.style.fontSize = '14px';
  toast.style.zIndex = 1000;
  document.body.appendChild(toast);

  setTimeout(() => {
    toast.style.opacity = '0';
    setTimeout(() => document.body.removeChild(toast), 500);
  }, 2000);
}


window.addEventListener('message', function(e) {
  if (e.data === 'added-to-cart') {
    showToast('✅ Dodano do koszyka');
  }
});
