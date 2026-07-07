<?php include '../includes/header.php'; ?>

<!-- External Libraries for Certificate Generation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Dancing+Script:wght@600&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">

<section class="section" style="padding-top: 150px;">
    <div class="section-title">
        <h2 style="color: var(--primary-color);">Student Achievements & Certificates</h2>
        <p style="color: var(--text-secondary);">Celebrating Elite Success at Technova University</p>
    </div>

    <!-- Achievement Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2.5rem; margin-bottom: 4rem;">
        <div class="glass-card" style="padding: 0; overflow: hidden; border: 1px solid rgba(212,175,55,0.2); background: var(--light-color);">
            <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=800&q=80" style="width: 100%; height: 250px; object-fit: cover;">
            <div style="padding: 2rem;">
                <span style="color: var(--primary-color); font-size: 0.8rem; text-transform: uppercase;">International Hackathon 2025</span>
                <h3 style="margin: 10px 0; color: var(--text-color);">Global Innovation Award</h3>
                <p style="color: var(--text-secondary);">Team Technova secured 1st place among 200+ global teams in the AI for Good Hackathon, London.</p>
            </div>
        </div>
        <div class="glass-card" style="padding: 0; overflow: hidden; border: 1px solid rgba(212,175,55,0.2); background: var(--light-color);">
            <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=800&q=80" style="width: 100%; height: 250px; object-fit: cover;">
            <div style="padding: 2rem;">
                <span style="color: var(--primary-color); font-size: 0.8rem; text-transform: uppercase;">Research Excellence</span>
                <h3 style="margin: 10px 0; color: var(--text-color);">Young Scientist Fellowship</h3>
                <p style="color: var(--text-secondary);">Our final-year student, Mehak Sharma, received the prestigious Ramanujan Fellowship for Quantum Research.</p>
            </div>
        </div>
    </div>

    <!-- Certificate Verification System -->
    <div id="blockchain-verification" class="glass-card" style="background: var(--light-color); text-align: center; padding: 4rem 2rem; border: 1px solid rgba(212,175,55,0.1);">
        <i class="fas fa-certificate" style="font-size: 4rem; color: var(--primary-color); margin-bottom: 1.5rem;"></i>
        <h2 style="color: var(--primary-color); margin-bottom: 1rem;">Technova Blockchain Certificates</h2>
        <p style="max-width: 800px; margin: 0 auto 2.5rem; color: var(--text-secondary);">Our degree and achievement certificates are secured by blockchain technology, ensuring 100% tamper-proof verification for global employers.</p>
        
        <div style="display: flex; gap: 1rem; justify-content: center; margin-bottom: 2rem;">
            <input type="text" id="cert-id" placeholder="Enter Certificate ID (e.g., TECH-2026-X1)" style="padding: 12px 20px; border-radius: 4px; border: 1px solid var(--primary-color); background: rgba(0,0,0,0.3); color: white; width: 350px; outline: none;">
            <button class="btn-primary" onclick="verifyCertificate()">Verify Now</button>
        </div>

        <div id="verification-result" style="max-width: 600px; margin: 0 auto; display: none;">
            <!-- Result will be injected here -->
        </div>
    </div>
</section>

<!-- Hidden Certificate Template for Download -->
<div id="cert-template" style="position: absolute; left: -9999px; top: -9999px;">
    <div id="certificate-content" style="width: 1000px; height: 700px; background: #0B0B0B; border: 20px solid #D4AF37; padding: 40px; color: #F5F5F5; font-family: 'Montserrat', sans-serif; position: relative; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; box-sizing: border-box; overflow: hidden;">
        
        <!-- Intricate Ornamental Corners (SVG) -->
        <svg style="position: absolute; top: 10px; left: 10px; width: 150px; height: 150px; fill: #D4AF37; opacity: 0.6;" viewBox="0 0 100 100">
            <path d="M0,0 L30,0 Q15,0 15,15 L15,30 Q15,15 0,15 Z" />
            <circle cx="15" cy="15" r="2" />
        </svg>
        <svg style="position: absolute; top: 10px; right: 10px; width: 150px; height: 150px; fill: #D4AF37; opacity: 0.6; transform: rotate(90deg);" viewBox="0 0 100 100">
            <path d="M0,0 L30,0 Q15,0 15,15 L15,30 Q15,15 0,15 Z" />
            <circle cx="15" cy="15" r="2" />
        </svg>
        <svg style="position: absolute; bottom: 10px; left: 10px; width: 150px; height: 150px; fill: #D4AF37; opacity: 0.6; transform: rotate(270deg);" viewBox="0 0 100 100">
            <path d="M0,0 L30,0 Q15,0 15,15 L15,30 Q15,15 0,15 Z" />
            <circle cx="15" cy="15" r="2" />
        </svg>
        <svg style="position: absolute; bottom: 10px; right: 10px; width: 150px; height: 150px; fill: #D4AF37; opacity: 0.6; transform: rotate(180deg);" viewBox="0 0 100 100">
            <path d="M0,0 L30,0 Q15,0 15,15 L15,30 Q15,15 0,15 Z" />
            <circle cx="15" cy="15" r="2" />
        </svg>

        <!-- Watermark Logo -->
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-30deg); font-size: 10rem; font-family: 'Cinzel', serif; color: rgba(212, 175, 55, 0.035); z-index: 0; pointer-events: none; text-transform: uppercase; font-weight: 900; white-space: nowrap; letter-spacing: 20px;">TECHNOVA</div>

        <div style="z-index: 1; width: 100%;">
            <div style="margin-bottom: 10px;">
                <i class="fas fa-award" style="font-size: 3.5rem; color: #D4AF37; filter: drop-shadow(0 0 10px rgba(212,175,55,0.4));"></i>
            </div>
            
            <h1 style="font-family: 'Cinzel', serif; font-size: 3.2rem; color: #D4AF37; text-transform: uppercase; letter-spacing: 10px; margin: 0; font-weight: 700; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">Technova University</h1>
            <p style="font-size: 0.9rem; letter-spacing: 6px; color: #D4AF37; margin-top: 5px; font-weight: 400; opacity: 0.8;">OFFICIAL ACADEMIC CREDENTIAL</p>
            
            <div style="margin: 30px auto; width: 70%; height: 1.5px; background: linear-gradient(to right, transparent, #D4AF37, #B8860B, #D4AF37, transparent);"></div>
            
            <h2 style="font-family: 'Playfair Display', serif; font-size: 2rem; color: #fff; font-weight: 400; font-style: italic; margin-bottom: 15px; letter-spacing: 1px;">Certificate of Academic Excellence</h2>
            <p style="font-size: 1.1rem; color: #aaa; margin-bottom: 5px; font-weight: 300;">This is to certify that the Board of Governors confers upon</p>
            
            <h3 id="cert-holder-name" style="font-family: 'Playfair Display', serif; font-size: 3.8rem; color: #D4AF37; margin: 10px 0; text-transform: capitalize; font-weight: 700; text-shadow: 1px 1px 2px rgba(0,0,0,0.8); letter-spacing: 2px;">Elite Student</h3>
            
            <p style="font-size: 1.1rem; color: #aaa; max-width: 80%; margin: 15px auto; font-weight: 300; line-height: 1.6;">the distinction of successfully completing all prescribed requirements and demonstrating exceptional proficiency in the field of</p>
            
            <h4 id="cert-achievement" style="font-family: 'Cinzel', serif; font-size: 1.8rem; color: #fff; margin: 10px 0; font-weight: 600; letter-spacing: 2px; border-bottom: 1px solid rgba(212,175,55,0.3); display: inline-block; padding-bottom: 5px;">Blockchain Architecture Specialization</h4>
            
            <!-- Bottom Section: Signatures & Seal -->
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; width: 100%; margin-top: 40px; align-items: flex-end;">
                <!-- Signature 1 -->
                <div style="text-align: center;">
                    <div style="font-family: 'Dancing Script', cursive; font-size: 2rem; color: #fff; border-bottom: 1.5px solid #D4AF37; width: 180px; margin: 0 auto 10px; padding-bottom: 2px; opacity: 0.9;">Dr. Aryan Sharma</div>
                    <p style="font-size: 0.75rem; color: #888; margin: 0; text-transform: uppercase; letter-spacing: 2px; font-weight: 600;">Vice Chancellor</p>
                </div>

                <!-- Official Gold Seal -->
                <div style="text-align: center; position: relative; height: 130px;">
                    <div style="width: 120px; height: 120px; background: radial-gradient(circle, #D4AF37 0%, #B8860B 100%); border-radius: 50%; margin: 0 auto; border: 5px double #8B6508; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 20px rgba(0,0,0,0.4); transform: rotate(-5deg);">
                        <div style="width: 100px; height: 100px; border: 1.5px dashed rgba(255,255,255,0.4); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                            <i class="fas fa-university" style="font-size: 2.2rem; color: #fff; opacity: 0.9;"></i>
                            <span style="font-size: 0.55rem; font-weight: 800; color: #fff; margin-top: 4px; letter-spacing: 1px;">OFFICIAL SEAL</span>
                        </div>
                    </div>
                </div>

                <!-- Signature 2 -->
                <div style="text-align: center;">
                    <div style="font-family: 'Dancing Script', cursive; font-size: 2rem; color: #fff; border-bottom: 1.5px solid #D4AF37; width: 180px; margin: 0 auto 10px; padding-bottom: 2px; opacity: 0.9;">Mehak Malhotra</div>
                    <p style="font-size: 0.75rem; color: #888; margin: 0; text-transform: uppercase; letter-spacing: 2px; font-weight: 600;">Registrar Academics</p>
                </div>
            </div>

            <!-- Validation Footer -->
            <div style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-top: 35px; border-top: 1px solid rgba(212,175,55,0.15); padding-top: 15px;">
                <div style="text-align: left; flex: 1;">
                    <p style="font-size: 0.7rem; color: #666; margin: 0; text-transform: uppercase; letter-spacing: 1px;">Credential ID</p>
                    <p id="cert-display-id" style="font-size: 0.9rem; color: #D4AF37; font-weight: 600; margin: 0;">TECH-2026-X1</p>
                </div>
                
                <div style="flex: 1; display: flex; flex-direction: column; align-items: center;">
                    <!-- Verification QR Simulation -->
                    <div style="width: 50px; height: 50px; background: white; padding: 4px; border-radius: 4px; margin-bottom: 5px; opacity: 0.8;">
                        <div style="width: 100%; height: 100%; background: repeating-conic-gradient(#000 0% 25%, #fff 0% 50%) 50% / 8px 8px;"></div>
                    </div>
                    <p style="font-size: 0.55rem; color: #444; margin: 0; letter-spacing: 0.5px;">Scan to Verify on Blockchain</p>
                </div>

                <div style="text-align: right; flex: 1;">
                    <p style="font-size: 0.7rem; color: #666; margin: 0; text-transform: uppercase; letter-spacing: 1px;">Issue Date</p>
                    <p id="cert-date" style="font-size: 0.9rem; color: #fff; margin: 0; font-weight: 500;"><?php echo date('F d, Y'); ?></p>
                </div>
            </div>
            
            <!-- Ledger Hash -->
            <div style="margin-top: 10px; text-align: center; width: 100%;">
                <p style="font-size: 0.5rem; color: #333; margin: 0; font-family: monospace; letter-spacing: 1px;">BLOCKCHAIN_PROOF: 0x<?php echo strtoupper(bin2hex(random_bytes(24))); ?>_VERIFIED_AUTHENTIC</p>
            </div>
        </div>
    </div>
</div>

<script>
function downloadCertificate(certId) {
    const { jsPDF } = window.jspdf;
    const certElement = document.getElementById('certificate-content');
    
    // Update dynamic fields before capture
    document.getElementById('cert-display-id').innerText = certId;
    document.getElementById('cert-date').innerText = new Date().toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
    
    // Attempt to find the trigger button (handling cases where it might be called differently)
    const btn = event?.target?.closest('button') || document.querySelector('.btn-primary');
    const originalText = btn ? btn.innerHTML : '';
    
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Authenticating...';
    }

    html2canvas(certElement, {
        scale: 3, // Higher scale for ultra-professional print quality
        useCORS: true,
        backgroundColor: '#0B0B0B',
        logging: false
    }).then(canvas => {
        const imgData = canvas.toDataURL('image/png', 1.0);
        const pdf = new jsPDF({
            orientation: 'landscape',
            unit: 'px',
            format: [1000, 700]
        });
        
        pdf.addImage(imgData, 'PNG', 0, 0, 1000, 700, undefined, 'FAST');
        pdf.save(`Technova_Official_Credential_${certId}.pdf`);
        
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    });
}

function verifyCertificate() {
    const certId = document.getElementById('cert-id').value.trim();
    const resultDiv = document.getElementById('verification-result');
    const currentDate = new Date().toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
    
    if (!certId) {
        alert('Please enter a valid Certificate ID');
        return;
    }

    // Professional loading state
    resultDiv.style.display = 'block';
    resultDiv.innerHTML = `
        <div style="padding: 2rem; border-radius: 8px; background: rgba(212,175,55,0.05); border: 1px dashed var(--primary-color);">
            <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: var(--primary-color);"></i>
            <p style="margin-top: 1rem; color: var(--text-secondary);">Accessing Technova Blockchain Ledger...</p>
        </div>
    `;

    // Simulate blockchain verification
    setTimeout(() => {
        // Professional simulation of verification
        if (certId.startsWith('TECH-2026')) {
            resultDiv.innerHTML = `
                <div class="reveal" style="padding: 2rem; border-radius: 8px; background: rgba(39, 174, 96, 0.1); border: 1px solid #27ae60; text-align: left;">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 1.5rem;">
                        <i class="fas fa-check-circle" style="font-size: 3rem; color: #27ae60;"></i>
                        <div>
                            <h3 style="color: #27ae60; margin: 0;">Verified Authentic</h3>
                            <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0;">Block Hash: 0x7f2a...9e41</p>
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; color: var(--text-secondary); font-size: 0.9rem;">
                        <div>
                            <p style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; margin-bottom: 5px;">Candidate Name</p>
                            <p style="font-weight: 600; color: var(--text-color);">Elite Student - Technova</p>
                        </div>
                        <div>
                            <p style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; margin-bottom: 5px;">Issuance Date</p>
                            <p style="font-weight: 600; color: var(--text-color);">${currentDate}</p>
                        </div>
                        <div style="grid-column: span 2;">
                            <p style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; margin-bottom: 5px;">Program / Achievement</p>
                            <p style="font-weight: 600; color: var(--primary-color);">Blockchain Architecture Specialization</p>
                        </div>
                    </div>
                    <div style="margin-top: 1.5rem; text-align: center; display: flex; gap: 10px; justify-content: center;">
                        <button class="btn-outline" style="padding: 8px 20px; font-size: 0.8rem;"><i class="fas fa-link"></i> View on Ledger</button>
                        <button class="btn-primary" onclick="downloadCertificate('${certId}')" style="padding: 8px 20px; font-size: 0.8rem; border: none;"><i class="fas fa-download"></i> Download Certificate</button>
                    </div>
                </div>
            `;
        } else {
            resultDiv.innerHTML = `
                <div class="reveal" style="padding: 2rem; border-radius: 8px; background: rgba(231, 76, 60, 0.1); border: 1px solid #e74c3c;">
                    <i class="fas fa-times-circle" style="font-size: 3rem; color: #e74c3c; margin-bottom: 1rem;"></i>
                    <h3 style="color: #e74c3c;">Verification Failed</h3>
                    <p style="color: var(--text-secondary);">The provided ID was not found on the Technova Blockchain Ledger. Please check for typos or contact the registrar.</p>
                </div>
            `;
        }
    }, 2000);
}
</script>

<?php include '../includes/footer.php'; ?>
