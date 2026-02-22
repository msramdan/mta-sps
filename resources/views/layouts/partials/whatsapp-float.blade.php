@php
    $waNumber = '6283874731480';
    $waText = 'Halo admin, saya mau tanya terkait QRIN';
    $waUrl = 'https://wa.me/' . $waNumber . '?text=' . rawurlencode($waText);
@endphp
<a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="whatsapp-float">
    <i class="fab fa-whatsapp"></i>
    <span class="whatsapp-float-label">Hubungi Kami</span>
</a>
<style>
    .whatsapp-float {
        position: fixed;
        bottom: 20px;
        left: 20px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px 8px 8px;
        background: #25D366;
        color: #fff;
        border-radius: 24px;
        box-shadow: 0 3px 10px rgba(37, 211, 102, 0.4);
        z-index: 9999;
        transition: transform 0.2s, box-shadow 0.2s;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
    }
    .whatsapp-float:hover {
        color: #fff;
        transform: scale(1.03);
        box-shadow: 0 4px 14px rgba(37, 211, 102, 0.5);
    }
    .whatsapp-float i {
        font-size: 20px;
    }
    .whatsapp-float-label {
        white-space: nowrap;
    }
    @media (max-width: 768px) {
        .whatsapp-float {
            bottom: 72px;
        }
    }
</style>
