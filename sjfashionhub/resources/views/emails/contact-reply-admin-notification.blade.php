<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Reply - Support Ticket</title>
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
        .ticket-id {
            background-color: #dbeafe;
            color: #1e40af;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 20px;
        }
        .customer-info {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            margin: 20px 0;
        }
        .reply-box {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #f59e0b;
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
        .btn-urgent {
            background-color: #dc2626;
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
    </style>
</head>
<body>
    <div class="header">
        <h1>🔔 Customer Reply Received</h1>
        <p>A customer has replied to their support ticket</p>
    </div>

    <div class="content">
        <div class="ticket-id">
            Ticket #{{ $contact->id }}
        </div>

        <p>A customer has replied to their support ticket. Please review and respond promptly.</p>

        <div class="customer-info">
            <h3 style="margin-top: 0; color: #1f2937;">👤 Customer Information</h3>
            
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
                <span class="label">Status:</span>
                <span class="value">{{ ucfirst($contact->status) }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Reply Time:</span>
                <span class="value">{{ $reply->created_at->format('F j, Y \a\t g:i A') }}</span>
            </div>
        </div>

        <div class="reply-box">
            <h3 style="margin-top: 0; color: #92400e;">💬 Customer's New Reply</h3>
            <div style="margin: 15px 0;">
                <strong>From:</strong> {{ $reply->sender_display_name }} ({{ $reply->sender_email ?: $contact->email }})
            </div>
            <div style="white-space: pre-wrap; line-height: 1.6; background-color: #fef3c7; padding: 15px; border-radius: 6px;">{{ $reply->message }}</div>
        </div>

        <div style="background-color: #f8fafc; padding: 15px; border-radius: 6px; border-left: 4px solid #6b7280; margin: 20px 0;">
            <h4 style="margin-top: 0; color: #374151;">📝 Original Customer Message</h4>
            <div style="white-space: pre-wrap; color: #6b7280;">{{ Str::limit($contact->message, 300) }}</div>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <h3 style="color: #1f2937;">⚡ Quick Actions</h3>
            
            <a href="{{ route('admin.contacts.show', $contact) }}" class="btn">
                View Full Ticket
            </a>
            <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }} (Ticket #{{ $contact->id }})" class="btn">
                Reply via Email
            </a>
        </div>

        <div style="background-color: #fef2f2; padding: 20px; border-radius: 8px; border-left: 4px solid #dc2626; margin: 20px 0;">
            <h4 style="margin-top: 0; color: #991b1b;">⏰ Response Time Reminder</h4>
            <ul style="margin: 10px 0; padding-left: 20px; color: #7f1d1d;">
                <li>Standard response time: Within 24 hours</li>
                <li>Priority tickets: Within 4 hours</li>
                <li>Urgent issues: Within 1 hour</li>
            </ul>
        </div>

        <div style="background-color: #ecfdf5; padding: 15px; border-radius: 6px; border-left: 4px solid #10b981; margin: 20px 0;">
            <strong>Quick Reply Tips:</strong><br>
            • Reply directly to this email to respond to the customer<br>
            • Use the admin panel for internal notes and status updates<br>
            • Include the ticket number (#{{ $contact->id }}) in all communications<br>
            • Mark as resolved when the issue is fully addressed
        </div>

        <div style="text-align: center; margin: 20px 0;">
            <p style="color: #6b7280; font-size: 14px;">
                <strong>Ticket History:</strong> {{ $contact->replies()->count() + 1 }} messages total<br>
                <strong>Last Admin Reply:</strong> {{ $contact->replies()->adminReplies()->latest()->first()?->created_at?->diffForHumans() ?: 'No previous admin replies' }}
            </p>
        </div>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} SJ Fashion Hub Admin Panel</p>
        <p>This is an automated notification for support ticket activity.</p>
    </div>
</body>
</html>
