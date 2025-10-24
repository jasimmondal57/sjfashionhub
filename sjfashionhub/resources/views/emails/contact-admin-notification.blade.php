<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
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
            padding: 20px;
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
            padding: 15px;
            text-align: center;
            border-radius: 0 0 8px 8px;
            font-size: 14px;
        }
        .info-row {
            margin-bottom: 15px;
            padding: 10px;
            background-color: white;
            border-left: 4px solid #3b82f6;
            border-radius: 4px;
        }
        .label {
            font-weight: bold;
            color: #374151;
            margin-bottom: 5px;
        }
        .value {
            color: #6b7280;
        }
        .message-box {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            margin-top: 20px;
        }
        .ticket-id {
            background-color: #dbeafe;
            color: #1e40af;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            background-color: #3b82f6;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: #2563eb;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🔔 New Contact Form Submission</h1>
        <p>SJ Fashion Hub Admin Panel</p>
    </div>

    <div class="content">
        <div class="ticket-id">
            Ticket #{{ $contact->id }}
        </div>

        <p>A new contact form has been submitted on your website. Here are the details:</p>

        <div class="info-row">
            <div class="label">Customer Name:</div>
            <div class="value">{{ $contact->full_name }}</div>
        </div>

        <div class="info-row">
            <div class="label">Email Address:</div>
            <div class="value">{{ $contact->email }}</div>
        </div>

        @if($contact->phone)
        <div class="info-row">
            <div class="label">Phone Number:</div>
            <div class="value">{{ $contact->phone }}</div>
        </div>
        @endif

        <div class="info-row">
            <div class="label">Subject:</div>
            <div class="value">{{ ucfirst(str_replace('_', ' ', $contact->subject)) }}</div>
        </div>

        <div class="info-row">
            <div class="label">Submission Date:</div>
            <div class="value">{{ $contact->created_at->format('F j, Y \a\t g:i A') }}</div>
        </div>

        <div class="info-row">
            <div class="label">IP Address:</div>
            <div class="value">{{ $contact->ip_address ?? 'N/A' }}</div>
        </div>

        <div class="message-box">
            <div class="label">Message:</div>
            <div style="margin-top: 10px; white-space: pre-wrap;">{{ $contact->message }}</div>
        </div>

        <div style="text-align: center;">
            <a href="{{ route('admin.contacts.show', $contact) }}" class="btn">
                View in Admin Panel
            </a>
        </div>

        <div style="margin-top: 30px; padding: 15px; background-color: #fef3c7; border-radius: 6px; border-left: 4px solid #f59e0b;">
            <strong>Quick Actions:</strong><br>
            • Reply directly to this email to respond to the customer<br>
            • <a href="{{ route('admin.contacts.show', $contact) }}">View full details in admin panel</a><br>
            • <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }} (Ticket #{{ $contact->id }})">Send direct email reply</a>
        </div>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} SJ Fashion Hub. All rights reserved.</p>
        <p>This is an automated notification from your contact form system.</p>
    </div>
</body>
</html>
