@php
    // The stored message is a plain-text block built in submitContact().
    $lines = preg_split('/\R/', trim($enquiry->message));
    $storyAt = array_search('Story:', $lines, true);
    $details = $storyAt === false ? $lines : array_slice($lines, 0, $storyAt);
    $story = $storyAt === false ? '' : trim(implode("\n", array_slice($lines, $storyAt + 1)));

    $replyOn = $channel === 'email' ? $enquiry->email : $enquiry->phone;
@endphp
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>New Storyloom enquiry</title></head>
<body style="margin:0; padding:24px; background:#f4f1eb; font-family: -apple-system, Segoe UI, Helvetica, Arial, sans-serif; color:#1C222B;">
  <div style="max-width:600px; margin:0 auto; background:#ffffff; border:1px solid #e8e3db; border-radius:6px; overflow:hidden;">

    <div style="background:#1D2A44; padding:20px 24px;">
      <p style="margin:0; color:#E8A87C; font-size:12px; letter-spacing:.18em; text-transform:uppercase; font-weight:700;">New enquiry</p>
      <p style="margin:6px 0 0; color:#FFFDF8; font-size:20px; font-weight:600;">{{ $enquiry->name }}</p>
    </div>

    <div style="padding:24px;">
      <p style="margin:0 0 18px; padding:12px 14px; background:#FAF2EC; border-left:3px solid #B55B29; font-size:14px;">
        <strong>Reply on {{ $channel === 'email' ? 'email' : 'WhatsApp' }}:</strong>
        {{ $replyOn ?: 'not provided' }}
      </p>

      <table style="width:100%; border-collapse:collapse; font-size:14px;">
        @foreach($details as $line)
          @php [$label, $value] = array_pad(explode(':', $line, 2), 2, ''); @endphp
          @if(trim($line) !== '')
            <tr>
              <td style="padding:6px 0; color:#7A756C; width:150px; vertical-align:top;">{{ trim($label) }}</td>
              <td style="padding:6px 0; vertical-align:top;">{{ trim($value) }}</td>
            </tr>
          @endif
        @endforeach
        <tr>
          <td style="padding:6px 0; color:#7A756C; vertical-align:top;">Email</td>
          <td style="padding:6px 0; vertical-align:top;">{{ $enquiry->email !== 'anonymous@storyloom.in' ? $enquiry->email : '—' }}</td>
        </tr>
        <tr>
          <td style="padding:6px 0; color:#7A756C; vertical-align:top;">Phone</td>
          <td style="padding:6px 0; vertical-align:top;">{{ $enquiry->phone ?: '—' }}</td>
        </tr>
      </table>

      @if($story !== '')
        <p style="margin:22px 0 6px; color:#7A756C; font-size:12px; letter-spacing:.16em; text-transform:uppercase; font-weight:700;">Their memory</p>
        <div style="padding:14px 16px; background:#f7f4ed; border:1px solid #e8e3db; font-size:15px; line-height:1.6; white-space:pre-wrap;">{{ $story }}</div>
      @endif

      <p style="margin:24px 0 0; font-size:13px; color:#7A756C;">
        Also saved in the dashboard under
        <a href="{{ route('admin.messages.show', $enquiry->id) }}" style="color:#B55B29;">Messages &rsaquo; #{{ $enquiry->id }}</a>.
      </p>
    </div>
  </div>
</body>
</html>
