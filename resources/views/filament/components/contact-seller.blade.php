<div class="space-y-4">
    <div class="text-sm text-gray-600">
        <p>For inquiries or purchases, feel free to reach out through the contact details below:</p>
    </div>

    <div class="grid grid-cols-2 gap-3 text-sm">
        <div>
            <strong>Phone:</strong> {{ $contact->phone ?? '—' }}
        </div>
        <div>
            <strong>WhatsApp:</strong> {{ $contact->whatsapp ?? '—' }}
        </div>
        <div>
            <strong>Viber:</strong> {{ $contact->viber ?? '—' }}
        </div>
        <div>
            <strong>Instagram:</strong> {{ $contact->instagram ?? '—' }}
        </div>
    </div>
</div>