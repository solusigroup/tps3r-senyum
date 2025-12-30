<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Laporan') - TPS3R Senyum</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 10pt; line-height: 1.4; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #065f46; padding-bottom: 10px; }
        .header h1 { font-size: 16pt; color: #065f46; margin-bottom: 5px; }
        .header h2 { font-size: 12pt; font-weight: normal; }
        .header p { font-size: 9pt; color: #666; }
        .summary { margin-bottom: 15px; }
        .summary-box { display: inline-block; background: #f0fdf4; padding: 8px 15px; border-radius: 5px; margin-right: 10px; border: 1px solid #d1fae5; }
        .summary-box .label { font-size: 8pt; color: #666; }
        .summary-box .value { font-size: 12pt; font-weight: bold; color: #065f46; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #065f46; color: white; padding: 8px 5px; text-align: left; font-size: 9pt; }
        td { padding: 6px 5px; border-bottom: 1px solid #e2e8f0; font-size: 9pt; }
        tr:nth-child(even) { background: #f8fafc; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .badge { padding: 2px 6px; border-radius: 3px; font-size: 8pt; font-weight: bold; }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-danger { background: #fee2e2; color: #dc2626; }
        .badge-info { background: #dbeafe; color: #2563eb; }
        .badge-warning { background: #fef3c7; color: #d97706; }
        .footer { margin-top: 20px; text-align: center; font-size: 8pt; color: #666; border-top: 1px solid #e2e8f0; padding-top: 10px; }
        .text-green { color: #059669; }
        .text-red { color: #dc2626; }
        .font-bold { font-weight: bold; }
        tfoot td { font-weight: bold; background: #f1f5f9; }
    </style>
</head>
<body>
    <div class="header">
        <h1>TPS3R Senyum</h1>
        <h2>@yield('report_title', 'Laporan')</h2>
        <p>Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    @yield('content')

    <div class="footer">
        TPS3R Senyum - Sistem Pengelolaan Sampah
    </div>
</body>
</html>
