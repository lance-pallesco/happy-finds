import './bootstrap';

// Import Swiper bundle (includes all modules)
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';

// Make it globally accessible (for Alpine init)
window.Swiper = Swiper;

console.log('Swiper loaded ✅');