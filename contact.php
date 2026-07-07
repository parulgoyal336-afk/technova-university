<?php include '../includes/header.php'; ?>

<section class="section" style="padding-top: 150px;">
    <div class="section-title">
        <h2 style="color: var(--primary-color);">Global Contact Hub</h2>
        <p style="color: var(--text-secondary);">Elite Concierge & University Admissions</p>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 3rem;">
        <div class="glass-card" style="background: var(--light-color); border: 1px solid rgba(212,175,55,0.2);">
            <h3 style="color: var(--primary-color);">Technova Headquarters</h3>
            <p style="margin-bottom: 1.5rem; color: var(--text-secondary);">Experience the excellence in person. Visit our elite campus in Mandi Gobindgarh, Punjab.</p>
            <div style="margin-bottom: 1rem;">
                <p style="color: var(--text-secondary);"><i class="fas fa-map-marker-alt" style="color: var(--primary-color); width: 25px;"></i> Gobindgarh Public College, Alour, Khanna-Amloh Road, Mandi Gobindgarh, Punjab 147301</p>
            </div>
            <div style="margin-bottom: 1rem;">
                <p style="color: var(--text-secondary);"><i class="fas fa-phone" style="color: var(--primary-color); width: 25px;"></i> +91 1765 257 100 (Admissions)</p>
            </div>
            <div style="margin-bottom: 1rem;">
                <p style="color: var(--text-secondary);"><i class="fas fa-envelope" style="color: var(--primary-color); width: 25px;"></i> admissions@technova.edu.in</p>
            </div>
            <div style="margin-bottom: 2rem;">
                <p style="color: var(--text-secondary);"><i class="fas fa-clock" style="color: var(--primary-color); width: 25px;"></i> Mon - Sat: 9:00 AM - 4:00 PM IST</p>
            </div>
            <h3 style="color: var(--primary-color);">Connect With Us</h3>
            <div class="social-links" style="margin-top: 1.5rem; display: flex; gap: 1.5rem;">
                <a href="https://www.instagram.com/" target="_blank" class="social-icon-box"><i class="fab fa-instagram"></i></a>
                <a href="https://www.facebook.com/" target="_blank" class="social-icon-box"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.linkedin.com/" target="_blank" class="social-icon-box"><i class="fab fa-linkedin-in"></i></a>
                <a href="https://twitter.com/" target="_blank" class="social-icon-box"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
        <div class="glass-card" style="background: var(--light-color); border: 1px solid rgba(212,175,55,0.2);">
            <h3 style="color: var(--primary-color);">Concierge Enquiry</h3>
            <form action="#" method="POST" style="margin-top: 1.5rem;">
                <div style="margin-bottom: 1.2rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Your Name</label>
                    <input type="text" name="name" required style="width: 100%; padding: 12px; border: 1px solid rgba(212,175,55,0.3); border-radius: 4px; background: rgba(0,0,0,0.5); color: white;">
                </div>
                <div style="margin-bottom: 1.2rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Your Email</label>
                    <input type="email" name="email" required style="width: 100%; padding: 12px; border: 1px solid rgba(212,175,55,0.3); border-radius: 4px; background: rgba(0,0,0,0.5); color: white;">
                </div>
                <div style="margin-bottom: 1.2rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Program of Interest</label>
                    <select name="subject" required style="width: 100%; padding: 12px; border: 1px solid rgba(212,175,55,0.3); border-radius: 4px; background: rgba(0,0,0,0.5); color: white;">
                        <option value="B.Tech CSE">B.Tech Computer Science (Elite)</option>
                        <option value="MBA">MBA Global Business</option>
                        <option value="Research">Research & Innovation</option>
                        <option value="Other">Other Enquiry</option>
                    </select>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Message</label>
                    <textarea name="message" rows="4" required style="width: 100%; padding: 12px; border: 1px solid rgba(212,175,55,0.3); border-radius: 4px; background: rgba(0,0,0,0.5); color: white; resize: none;"></textarea>
                </div>
                <button type="submit" class="btn-primary" style="width: 100%; letter-spacing: 2px;">SEND ENQUIRY</button>
            </form>
        </div>
    </div>
</section>

<section class="section">
    <div class="section-title">
        <h2 style="color: var(--primary-color);">Campus Location Hub</h2>
    </div>
    <div style="width: 100%; height: 500px; border-radius: 15px; overflow: hidden; box-shadow: var(--shadow); border: 1px solid rgba(212,175,55,0.2);">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3433.41456789!2d76.2123456!3d30.654321!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39100123456789ab%3A0x1234567890abcdef!2sGobindgarh%20Public%20College!5e0!3m2!1sen!2sin!4v1620000000000!5m2!1sen!2sin" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
</section>

<?php include '../includes/footer.php'; ?>
