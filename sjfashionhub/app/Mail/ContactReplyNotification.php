<?php

namespace App\Mail;

use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactReplyNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Contact $contact;
    public ContactReply $reply;
    public string $recipientType; // 'user' or 'admin'

    /**
     * Create a new message instance.
     */
    public function __construct(Contact $contact, ContactReply $reply, string $recipientType = 'user')
    {
        $this->contact = $contact;
        $this->reply = $reply;
        $this->recipientType = $recipientType;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->recipientType === 'user'
            ? "New Reply to Your Support Ticket #{$this->contact->id}"
            : "New Customer Reply - Ticket #{$this->contact->id}";

        // Get main admin email (super_admin) for replyTo
        $mainAdminEmail = User::where('role', 'super_admin')->first()?->email ?? 'superadmin@sjfashionhub.com';

        return new Envelope(
            subject: $subject,
            replyTo: $this->recipientType === 'user'
                ? [$mainAdminEmail]
                : [$this->contact->email],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $view = $this->recipientType === 'user'
            ? 'emails.contact-reply-user-notification'
            : 'emails.contact-reply-admin-notification';

        return new Content(
            view: $view,
            with: [
                'contact' => $this->contact,
                'reply' => $this->reply,
                'recipientType' => $this->recipientType,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
