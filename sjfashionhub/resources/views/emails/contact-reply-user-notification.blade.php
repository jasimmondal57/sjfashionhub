<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Reply to Your Support Ticket</title>
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
        .reply-box {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #10b981;
            margin: 20px 0;
        }
        .original-message {
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 6px;
            border-left: 4px solid #6b7280;
            margin: 20px 0;
        }
        .btn {
            display: inline-block;
            background-color: #3b82f6;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 10px 5px;
        }
        .btn-secondary {
            background-color: #10b981;
        }
        .info-box {
            background-color: #fef3c7;
            padding: 15px;
            border-radius: 6px;
            border-left: 4px solid #f59e0b;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📬 New Reply to Your Support Ticket</h1>
        <p>Our support team has responded to your inquiry</p>
    </div>

    <div class="content">
        <p>Hello {{ $contact->first_name }},</p>

        <p>Great news! Our support team has replied to your ticket. Here are the details:</p>

        <div class="ticket-box">
            <div class="ticket-id">Ticket #{{ $contact->id }}</div>
            <p><strong>Subject:</strong> {{ ucfirst(str_replace('_', ' ', $contact->subject)) }}</p>
        </div>

        <div class="reply-box">
            <h3 style="margin-top: 0; color: #065f46;">💬 New Reply from {{ $reply->sender_display_name }}</h3>
            <div style="margin: 15px 0;">
                <strong>Replied on:</strong> {{ $reply->created_at->format('F j, Y \a\t g:i A') }}
            </div>
            <div style="white-space: pre-wrap; line-height: 1.6;">{{ $reply->message }}</div>
        </div>

        <div class="original-message">
            <h4 style="margin-top: 0; color: #374151;">📝 Your Original Message</h4>
            <div style="white-space: pre-wrap; color: #6b7280;">{{ Str::limit($contact->message, 300) }}</div>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <h3 style="color: #1f2937;">🔄 Need to Reply?</h3>
            <p>You can continue the conversation by replying to this email or visiting your support portal.</p>
            
            <a href="{{ url('/account/support') }}" class="btn">
                View Ticket in Portal
            </a>
            <a href="mailto:{{ config('mail.admin_email', 'admin@sjfashionhub.com') }}?subject=Re: Ticket #{{ $contact->id }} - {{ $contact->subject }}" class="btn btn-secondary">
                Reply via Email
            </a>
        </div>

        <div class="info-box">
            <h4 style="margin-top: 0; color: #92400e;">📋 Ticket Information</h4>
            <p><strong>Ticket ID:</strong> #{{ $contact->id }}</p>
            <p><strong>Status:</strong> {{ ucfirst($contact->status) }}</p>
            <p><strong>Created:</strong> {{ $contact->created_at->format('F j, Y \a\t g:i A') }}</p>
            <p><strong>Last Updated:</strong> {{ $reply->created_at->format('F j, Y \a\t g:i A') }}</p>
        </div>

        <div style="background-color: #ecfdf5; padding: 20px; border-radius: 8px; border-left: 4px solid #10b981; margin: 20px 0;">
            <h4 style="margin-top: 0; color: #065f46;">💡 Quick Tips</h4>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Reply to this email to continue the conversation</li>
                <li>Include your ticket number (#{{ $contact->id }}) in any communication</li>
                <li>Check your account portal for all ticket history</li>
                <li>Our support team typically responds within 24 hours</li>
            </ul>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <h3 style="color: #1f2937;">🛍️ While You're Here</h3>
            <p>Don't forget to check out our latest collections!</p>
            <a href="{{ url('/') }}" class="btn">
                Visit Our Store
            </a>
        </div>
    </div>

    <div class="footer">
        <p><strong>SJ Fashion Hub Support Team</strong></p>
        <p>&copy; {{ date('Y') }} SJ Fashion Hub. All rights reserved.</p>
        <p>This is an automated notification. You can reply directly to this email.</p>
        <p><strong>Support Email:</strong> {{ config('mail.admin_email', 'admin@sjfashionhub.com') }}</p>
    </div>
</body>
</html>
