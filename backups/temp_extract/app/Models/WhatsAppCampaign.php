<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WhatsAppCampaign extends Model
{
    use SoftDeletes;

    protected $table = 'whatsapp_campaigns';

    protected $fillable = [
        'account_id',
        'name',
        'description',
        'template_id',
        'status',
        'target_audience',
        'variable_values',
        'scheduled_at',
        'started_at',
        'completed_at',
        'total_recipients',
        'sent_count',
        'delivered_count',
        'read_count',
        'failed_count',
    ];

    protected $casts = [
        'target_audience' => 'array',
        'variable_values' => 'array',
        'scheduled_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the WhatsApp account for this campaign
     */
    public function account()
    {
        return $this->belongsTo(WhatsAppAccount::class, 'account_id');
    }

    /**
     * Get the template for this campaign
     */
    public function template()
    {
        return $this->belongsTo(WhatsAppTemplate::class, 'template_id');
    }

    /**
     * Get campaign recipients
     */
    public function recipients()
    {
        return $this->hasMany(WhatsAppCampaignRecipient::class, 'campaign_id');
    }

    /**
     * Get success rate percentage
     */
    public function getSuccessRateAttribute()
    {
        if ($this->total_recipients == 0) {
            return 0;
        }
        return round(($this->delivered_count / $this->total_recipients) * 100, 2);
    }

    /**
     * Get read rate percentage
     */
    public function getReadRateAttribute()
    {
        if ($this->delivered_count == 0) {
            return 0;
        }
        return round(($this->read_count / $this->delivered_count) * 100, 2);
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'draft' => 'gray',
            'scheduled' => 'blue',
            'running' => 'yellow',
            'completed' => 'green',
            'paused' => 'orange',
            default => 'gray',
        };
    }

    /**
     * Get status icon
     */
    public function getStatusIconAttribute()
    {
        return match($this->status) {
            'draft' => '📝',
            'scheduled' => '📅',
            'running' => '🚀',
            'completed' => '✅',
            'paused' => '⏸️',
            default => '📄',
        };
    }

    /**
     * Scope for active campaigns
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['scheduled', 'running']);
    }

    /**
     * Scope for completed campaigns
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}

