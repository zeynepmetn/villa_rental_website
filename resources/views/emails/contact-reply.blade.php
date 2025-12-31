<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Villa Kiralama - İletişim Yanıtı</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px;
        }
        .original-message {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .original-message h3 {
            margin-top: 0;
            color: #667eea;
            font-size: 16px;
        }
        .reply-message {
            background-color: #e8f4fd;
            border: 1px solid #b3d9ff;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .reply-message h3 {
            margin-top: 0;
            color: #0066cc;
            font-size: 16px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e9ecef;
            font-size: 14px;
            color: #6c757d;
        }
        .contact-info {
            margin: 15px 0;
        }
        .contact-info strong {
            color: #495057;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 15px 0;
            font-weight: 500;
        }
        .divider {
            height: 1px;
            background-color: #e9ecef;
            margin: 25px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>🏖️ Villa Kiralama</h1>
            <p>İletişim Mesajınıza Yanıt</p>
        </div>
        
        <div class="content">
            <p>Merhaba <strong>{{ $contact->name }}</strong>,</p>
            
            <p>{{ $contact->created_at->format('d.m.Y H:i') }} tarihinde göndermiş olduğunuz iletişim mesajınız için teşekkür ederiz. Mesajınızı inceledik ve aşağıda yanıtımızı bulabilirsiniz:</p>
            
            <div class="original-message">
                <h3>📩 Orijinal Mesajınız:</h3>
                <div class="contact-info">
                    <strong>Konu:</strong> {{ $contact->subject }}<br>
                    @if($contact->phone)
                    <strong>Telefon:</strong> {{ $contact->phone }}<br>
                    @endif
                    <strong>Tarih:</strong> {{ $contact->created_at->format('d.m.Y H:i') }}
                </div>
                <p><strong>Mesaj:</strong></p>
                <p>{{ $contact->message }}</p>
            </div>
            
            <div class="reply-message">
                <h3>💬 Yanıtımız:</h3>
                <p>{!! nl2br(e($replyMessage)) !!}</p>
            </div>
            
            <div class="divider"></div>
            
            <p>Başka sorularınız varsa lütfen bizimle iletişime geçmekten çekinmeyin. Size en iyi hizmeti sunmak için buradayız.</p>
            
            <div style="text-align: center;">
                <a href="{{ url('/') }}" class="btn">🏠 Web Sitemizi Ziyaret Edin</a>
            </div>
        </div>
        
        <div class="footer">
            <p><strong>Villa Kiralama</strong></p>
            <p>📧 E-posta: info@villakiralama.com | 📞 Telefon: +90 (555) 123 45 67</p>
            <p>🌐 Web: {{ url('/') }}</p>
            <p style="margin-top: 15px; font-size: 12px;">
                Bu e-posta otomatik olarak gönderilmiştir. Lütfen bu e-postaya yanıt vermeyiniz.
            </p>
        </div>
    </div>
</body>
</html> 