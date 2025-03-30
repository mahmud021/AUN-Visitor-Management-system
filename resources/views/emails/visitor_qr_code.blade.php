<p>Dear {{ $visitor->first_name }},</p>
<p>Your visit to the American University of Nigeria has been registered. Please use the QR code below to check in upon arrival.</p>
<p><strong>Visit Date:</strong> {{ $visitor->visit_date }}</p>
<p><strong>Start Time:</strong> {{ $visitor->start_time }}</p>
<p><strong>End Time:</strong> {{ $visitor->end_time }}</p>
<img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code">
<p>Present this QR code at the entrance for a quick check-in.</p>
<p>Thank you!</p>
