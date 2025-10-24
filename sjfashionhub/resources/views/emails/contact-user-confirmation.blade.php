<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank you for contacting us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #1f2937;
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f9fafb;
            padding: 30px;
            border: 1px solid #e5e7eb;
        }
        .footer {
            background-color: #1f2937;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 0 0 8px 8px;
            font-size: 14px;
        }
        .ticket-box {
            background-color: #dbeafe;
            border: 2px solid #3b82f6;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin: 20px 0;
        }
        .ticket-id {
            font-size: 24px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 10px;
        }
        .summary-box {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            margin: 20px 0;
        }
        .info-row {
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .label {
            font-weight: bold;
            color: #374151;
            display: inline-block;
            width: 120px;
        }
        .value {
            color: #6b7280;
        }
        .message-preview {
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 6px;
            border-left: 4px solid #3b82f6;
            margin-top: 15px;
            font-style: italic;
        }
        .contact-info {
            background-color: #ecfdf5;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #10b981;
            margin: 20px 0;
        }
        .social-links {
            text-align: center;
            margin: 20px 0;
        }
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #3b82f6;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>✅ Thank You for Contacting Us!</h1>
        <p>We've received your message and will get back to you soon</p>
    </div>

    <div class="content">
        <p>Dear {{ $contact->first_name }},</p>

        <p>Thank you for reaching out to <strong>SJ Fashion Hub</strong>! We have successfully received your message and our team will review it shortly.</p>

        <div class="ticket-box">
            <div class="ticket-id">Ticket #{{ $contact->id }}</div>
            <p>Please save this ticket number for your reference. You can use it when following up on your inquiry.</p>
        </div>

        <div class="summary-box">
            <h3 style="margin-top: 0; color: #1f2937;">📋 Your Submission Summary</h3>
            
            <div class="info-row">
                <span class="label">Name:</span>
                <span class="value">{{ $contact->full_name }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Email:</span>
                <span class="value">{{ $contact->email }}</span>
            </div>
            
            @if($contact->phone)
            <div class="info-row">
                <span class="label">Phone:</span>
                <span class="value">{{ $contact->phone }}</span>
            </div>
            @endif
            
            <div class="info-row">
                <span class="label">Subject:</span>
                <span class="value">{{ ucfirst(str_replace('_', ' ', $contact->subject)) }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Submitted:</span>
                <span class="value">{{ $contact->created_at->format('F j, Y \a\t g:i A') }}</span>
            </div>

            <div class="message-preview">
                <strong>Your Message:</strong><br>
                {{ Str::limit($contact->message, 200) }}
                @if(strlen($contact->message) > 200)
                    <em>... (truncated)</em>
                @endif
            </div>
        </div>

        <div class="contact-info">
            <h3 style="margin-top: 0; color: #065f46;">📞 What Happens Next?</h3>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Our customer service team will review your message within <strong>24 hours</strong></li>
                <li>You'll receive a personalized response via email</li>
                <li>For urgent matters, you can call us directly or visit our store</li>
                <li>Keep your ticket number (#{{ $contact->id }}) handy for faster assistance</li>
            </ul>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <h3 style="color: #1f2937;">🛍️ Continue Shopping</h3>
            <p>While you wait for our response, feel free to browse our latest collections!</p>
            <a href="{{ url('/') }}" style="display: inline-block; background-color: #3b82f6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 10px;">
                Visit Our Store
            </a>
            <a href="{{ url('/products') }}" style="display: inline-block; background-color: #10b981; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 10px;">
                Browse Products
            </a>
        </div>

        <div class="contact-info">
            <h3 style="margin-top: 0; color: #065f46;">📧 Alternative Contact Methods</h3>
            <p><strong>Email:</strong> support@sjfashionhub.com</p>
            <p><strong>Phone:</strong> +91 XXX-XXX-XXXX</p>
            <p><strong>Business Hours:</strong> Monday - Saturday, 9:00 AM - 6:00 PM</p>
            <p><strong>Address:</strong> Your Store Address Here</p>
        </div>

        <div class="social-links">
            <p><strong>Follow us on social media for updates and offers:</strong></p>
            <a href="#">Facebook</a> |
            <a href="#">Instagram</a> |
            <a href="#">Twitter</a> |
            <a href="#">WhatsApp</a>
        </div>
    </div>

    <div class="footer">
        <p><strong>SJ Fashion Hub</strong></p>
        <p>&copy; {{ date('Y') }} SJ Fashion Hub. All rights reserved.</p>
        <p>This is an automated confirmation email. Please do not reply directly to this email.</p>
        <p>If you need immediate assistance, please contact us through our website or call our support line.</p>
    </div>
</body>
</html>
