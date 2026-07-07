<style>
/*==============================
 NEWSLETTER
==============================*/
.newsletter-section {
    background: linear-gradient(135deg, #fc2779, #ff5ea7);
    padding: 70px 20px;
}

.max-w-2xl {
    max-width: 700px;
    margin: auto;
    text-align: center;
}

.text-3xl {
    font-size: 38px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 18px;
}

.newsletter-desc {
    color: rgba(255, 255, 255, .85);
    margin-bottom: 30px;
    font-size: 16px;
}

.newsletter-form {
    display: flex;
    gap: 12px;
    justify-content: center;
}

/*==============================
 NEWSLETTER INPUT & BUTTON
==============================*/
.input-premium {
    flex: 1;
    max-width: 450px;
    height: 55px;
    border: none;
    outline: none;
    border-radius: 50px;
    padding: 0 25px;
    font-size: 15px;
    background: #fff;
    box-shadow: 0 10px 25px rgba(0,0,0,.12);
    transition: all 0.3s ease;
}

.input-premium:focus {
    box-shadow: 0 0 0 4px rgba(255,255,255,.25);
}

.btn-premium-sub {
    height: 55px;
    padding: 0 35px;
    border: none;
    border-radius: 50px;
    background: #111;
    color: #fff;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-premium-sub:hover {
    background: #fff;
    color: #fc2779;
}

/*==============================
 FOOTER BASE
==============================*/
.bg-brand-dark {
    background: #111;
    padding: 60px 4% 30px 4%;
    color: #d7d7d7;
    font-family: 'Segoe UI', Roboto, sans-serif;
}

.footer-container {
    max-width: 1300px;
    margin: 0 auto;
}

/*==============================
 FEATURE BOXES
==============================*/
.features-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    border-bottom: 1px solid rgba(255,255,255,.12);
    padding-bottom: 40px;
    margin-bottom: 50px;
}

.feature-box {
    display: flex;
    gap: 18px;
    align-items: center;
}

.feature-icon-box {
    flex-shrink: 0;
    height: 55px;
    width: 55px;
    border-radius: 14px;
    background: #fc2779;
    display: flex;
    align-items: center;
    justify-content: center;
}

.feature-icon-box svg {
    height: 26px;
    width: 26px;
    color: #111;
}

.feature-info h4 {
    color: #fff;
    font-weight: 600;
    margin: 0 0 4px 0;
    font-size: 16px;
}

.feature-info p {
    margin: 0;
    font-size: 14px;
    color: #bdbdbd;
}

/*==============================
 MAIN FOOTER LINKS LINKS
==============================*/
.main-footer-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 40px;
    padding-bottom: 40px;
}

.footer-column h3 {
    color: #fff;
    margin-top: 0;
    margin-bottom: 22px;
    font-size: 19px;
    font-weight: 700;
}

.footer-column ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-column li {
    margin-bottom: 12px;
}

.footer-column a {
    color: #bdbdbd;
    text-decoration: none;
    transition: .3s;
    position: relative;
    font-size: 15px;
    display: inline-block;
}

.footer-column a:hover {
    color: #fc2779;
    padding-left: 6px;
}

.footer-column a::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: -4px;
    width: 0;
    height: 2px;
    background: #fc2779;
    transition: .3s;
}

.footer-column a:hover::after {
    width: 100%;
}

.connect-text {
    font-size: 14px;
    color: #bfbfbf;
    line-height: 1.6;
    margin-bottom: 18px;
}

/*==============================
 SOCIAL ICONS
==============================*/
.social-wrapper {
    display: flex;
    gap: 12px;
}

.social-btn {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: #333;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: .3s;
}

.social-btn:hover {
    background: #fc2779;
    transform: translateY(-5px);
    color: #fff;
}

/*==============================
 COPYRIGHT & BOTTOM BAR
==============================*/
.footer-bottom {
    border-top: 1px solid rgba(255,255,255,.12);
    padding-top: 35px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.copyright-text {
    color: #bfbfbf;
    font-size: 14px;
    margin: 0;
}

.contact-info-wrapper {
    display: flex;
    gap: 24px;
}

.contact-item {
    color: #bfbfbf;
    font-size: 14px;
}

.contact-item span {
    font-weight: 600;
    color: #fff;
}

/*==============================
 RESPONSIVE BREAKPOINTS
==============================*/
@media(max-width: 1024px) {
    .main-footer-grid {
        grid-template-columns: repeat(3, 1fr);
    }
    .features-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
}

@media(max-width: 768px) {
    .main-footer-grid {
        grid-template-columns: 1fr;
        text-align: center;
    }
    .newsletter-form {
        flex-direction: column;
        align-items: center;
    }
    .input-premium {
        width: 100%;
        max-width: 100%;
    }
    .btn-premium-sub {
        width: 100%;
    }
    .feature-box {
        flex-direction: column;
        text-align: center;
    }
    .social-wrapper {
        justify-content: center;
    }
    .footer-bottom {
        flex-direction: column;
        text-align: center;
    }
    .contact-info-wrapper {
        flex-direction: column;
        gap: 10px;
    }
    .text-3xl {
        font-size: 30px;
    }
}
</style>

<!-- Newsletter Section -->
<section class="newsletter-section">
    <div class="max-w-2xl">
        <h2 class="text-3xl">Join Our Beauty Club</h2>
        <p class="newsletter-desc">Get exclusive offers, early access to new products, and beauty tips delivered to your inbox.</p>
        
        <form class="newsletter-form">
            <input 
                type="email" 
                placeholder="Enter your email" 
                required
                class="input-premium"
            />
            <button type="submit" class="btn-premium-sub">Subscribe</button>
        </form>
    </div>
</section>

<!-- Footer Section -->
<footer class="bg-brand-dark">
    <div class="footer-container">
        
        <!-- Trust Features Grid -->
        <div class="features-grid">
            <!-- Feature 1 -->
            <div class="feature-box">
                <div class="feature-icon-box">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="feature-info">
                    <h4>Free Shipping</h4>
                    <p>On orders above ₹499 across India</p>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="feature-box">
                <div class="feature-icon-box">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m0 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="feature-info">
                    <h4>100% Authentic</h4>
                    <p>Verified products from 1900+ Brands</p>
                </div>
            </div>

            <!-- Feature 3 -->
            <div class="feature-box">
                <div class="feature-icon-box">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5-4a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="feature-info">
                    <h4>24/7 Support</h4>
                    <p>Dedicated customer service team</p>
                </div>
            </div>
        </div>

        <!-- Main Link Columns -->
        <div class="main-footer-grid">
            <!-- About Col -->
            <div class="footer-column">
                <h3>About NYKAA</h3>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Press</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </div>

            <!-- Help Col -->
            <div class="footer-column">
                <h3>Help & Support</h3>
                <ul>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Shipping Policy</a></li>
                    <li><a href="#">Returns & Cancellations</a></li>
                </ul>
            </div>

            <!-- Policies Col -->
            <div class="footer-column">
                <h3>Policies</h3>
                <ul>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Refund Policy</a></li>
                    <li><a href="#">Cookie Policy</a></li>
                </ul>
            </div>

            <!-- Shop Col -->
            <div class="footer-column">
                <h3>Shop</h3>
                <ul>
                    <li><a href="{{ route('home') }}">New Arrivals</a></li>
                    <li><a href="{{ route('collections.user') }}">Collections</a></li>
                    <li><a href="{{ route('home') }}">Best Sellers</a></li>
                    <li><a href="{{ route('home') }}">Special Offers</a></li>
                </ul>
            </div>

            <!-- Social Connect Col -->
            <div class="footer-column">
                <h3>Connect With Us</h3>
                <p class="connect-text">Follow us on social media for beauty tips and exclusive deals. Show us some love ❤</p>
                <div class="social-wrapper">
                    <a href="#" class="social-btn"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-btn"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-btn"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="social-btn"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
        </div>

        <!-- Bottom Footer Rights Bar -->
        <div class="footer-bottom">
            <p class="copyright-text">
                &copy; {{ date('Y') }} NYKAA E-RETAIL LIMITED. All Rights Reserved.
            </p>
            <div class="contact-info-wrapper">
                <div class="contact-item"><span>Call Us:</span> 1800-267-4444</div>
                <div class="contact-item"><span>Email:</span> support@nykaa.com</div>
            </div>
        </div>

    </div>
</footer>

<!-- Scripts Block Stay Intact -->
<script src="{{ asset('js/script.js') }}"></script>
<script>
const modal = document.getElementById("loginModal");

if(document.getElementById("openLogin")) {
    document.getElementById("openLogin").onclick = function(){
        modal.style.display = "block";
    }
}

if(document.querySelector(".close-login")) {
    document.querySelector(".close-login").onclick = function(){
        modal.style.display = "none";
    }
}

window.onclick = function(e){
    if(e.target == modal){
        modal.style.display = "none";
    }
}
</script>
</body>
</html>