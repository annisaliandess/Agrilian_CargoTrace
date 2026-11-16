# -*- coding: utf-8 -*-
"""
Generator Dokumen PDF Resmi: Buku Panduan & Alur Sistem AgriLian CargoTrace
Penulis: Annisa Liandes (Ayaa) - NIM 250180123
UAS Pemrograman Web 2 - Universitas Malikussaleh
"""

import os
from reportlab.lib.pagesizes import A4
from reportlab.lib import colors
from reportlab.lib.styles import getSampleStyleSheet, ParagraphStyle
from reportlab.platypus import (
    SimpleDocTemplate, Paragraph, Spacer, Table, TableStyle, PageBreak, KeepTogether, HRFlowable
)
from reportlab.pdfgen import canvas

# Palette Highland Forest AgriLian
C_DARK = colors.HexColor('#051F20')
C_PINE = colors.HexColor('#0B2B26')
C_FOREST = colors.HexColor('#163832')
C_SAGE = colors.HexColor('#8EB69B')
C_LIGHT = colors.HexColor('#DAF1DE')
C_SLATE = colors.HexColor('#0F172A')
C_MUTED = colors.HexColor('#475569')
C_BORDER = colors.HexColor('#CBD5E1')
C_BG_CARD = colors.HexColor('#F8FAFC')
C_AMBER_BG = colors.HexColor('#FFFBEB')
C_AMBER_BORDER = colors.HexColor('#FDE68A')
C_EMERALD_BG = colors.HexColor('#ECFDF5')
C_EMERALD_BORDER = colors.HexColor('#A7F3D0')

class NumberedCanvas(canvas.Canvas):
    """Canvas dua fase untuk menghitung total halaman secara otomatis (Page X of Y)"""
    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        self._saved_page_states = []

    def showPage(self):
        self._saved_page_states.append(dict(self.__dict__))
        self._startPage()

    def save(self):
        num_pages = len(self._saved_page_states)
        for state in self._saved_page_states:
            self.__dict__.update(state)
            self.draw_page_decorations(num_pages)
            super().showPage()
        super().save()

    def draw_page_decorations(self, total_pages):
        self.saveState()
        # Jangan gambar header/footer di halaman sampul (halaman 1)
        if self._pageNumber > 1:
            # Running Header
            self.setFont("Helvetica-Bold", 8)
            self.setFillColor(C_PINE)
            self.drawString(42, 810, "AGRILIAN CARGOTRACE")
            self.setFont("Helvetica", 8)
            self.setFillColor(C_MUTED)
            self.drawString(155, 810, "|  Buku Panduan & Alur Sistem Logistik Ekspor Multimoda")
            
            self.setStrokeColor(C_BORDER)
            self.setLineWidth(0.5)
            self.line(42, 802, 553, 802)

            # Running Footer
            self.line(42, 42, 553, 42)
            self.setFont("Helvetica", 8)
            self.setFillColor(C_MUTED)
            self.drawString(42, 30, "Annisa Liandes (NIM 250180123) - UAS Pemrograman Web 2 (Unimal)")
            page_text = f"Halaman {self._pageNumber} dari {total_pages}"
            self.drawRightString(553, 30, page_text)
        self.restoreState()

def build_pdf(filename="D:/Projects/cargotrace/docs/Buku_Panduan_Alur_AgriLian_CargoTrace.pdf"):
    doc = SimpleDocTemplate(
        filename,
        pagesize=A4,
        leftMargin=42,
        rightMargin=42,
        topMargin=52,
        bottomMargin=52
    )

    styles = getSampleStyleSheet()

    # Custom Typography Styles
    style_cover_badge = ParagraphStyle(
        'CoverBadge',
        fontName='Helvetica-Bold',
        fontSize=9,
        leading=12,
        textColor=C_PINE,
        alignment=1
    )
    style_cover_title = ParagraphStyle(
        'CoverTitle',
        fontName='Helvetica-Bold',
        fontSize=24,
        leading=30,
        textColor=C_DARK,
        alignment=1
    )
    style_cover_sub = ParagraphStyle(
        'CoverSub',
        fontName='Helvetica',
        fontSize=11,
        leading=16,
        textColor=C_MUTED,
        alignment=1
    )
    style_h1 = ParagraphStyle(
        'ChapterH1',
        fontName='Helvetica-Bold',
        fontSize=14,
        leading=18,
        textColor=C_DARK,
        spaceBefore=14,
        spaceAfter=8,
        keepWithNext=True
    )
    style_h2 = ParagraphStyle(
        'ChapterH2',
        fontName='Helvetica-Bold',
        fontSize=11,
        leading=15,
        textColor=C_FOREST,
        spaceBefore=10,
        spaceAfter=5,
        keepWithNext=True
    )
    style_body = ParagraphStyle(
        'CustomBody',
        fontName='Helvetica',
        fontSize=9.5,
        leading=14,
        textColor=C_SLATE,
        spaceAfter=6
    )
    style_body_bold = ParagraphStyle(
        'CustomBodyBold',
        fontName='Helvetica-Bold',
        fontSize=9.5,
        leading=14,
        textColor=C_SLATE,
        spaceAfter=6
    )
    style_callout = ParagraphStyle(
        'CalloutText',
        fontName='Helvetica',
        fontSize=9,
        leading=13.5,
        textColor=C_SLATE
    )
    style_table_cell = ParagraphStyle(
        'TableCell',
        fontName='Helvetica',
        fontSize=8.5,
        leading=12,
        textColor=C_SLATE
    )
    style_table_head = ParagraphStyle(
        'TableHead',
        fontName='Helvetica-Bold',
        fontSize=8.5,
        leading=12,
        textColor=colors.white
    )

    story = []

    # ========================================================
    # HALAMAN 1: COVER RESMI LAPORAN UAS
    # ========================================================
    story.append(Spacer(1, 40))
    story.append(Paragraph("DOKUMEN RESMI PANDUAN UAS &bull; PEMROGRAMAN WEB 2", style_cover_badge))
    story.append(Spacer(1, 15))
    story.append(Paragraph("AGRILIAN CARGOTRACE", style_cover_title))
    story.append(Spacer(1, 6))
    story.append(Paragraph("Highland Agro-Export Visibility Platform", ParagraphStyle('CoverSubBrand', fontName='Helvetica-Bold', fontSize=13, textColor=C_FOREST, alignment=1)))
    story.append(Spacer(1, 18))
    
    story.append(Paragraph(
        "Panduan Komprehensif Arsitektur Sistem, Pembagian Hak Akses Pengguna (RBAC), "
        "Alur Perjalanan Kargo Multimoda, dan Integrasi Telemetri Cuaca "
        "dari Dataran Tinggi Gayo (Takengon) ke Pelabuhan Rotterdam.",
        style_cover_sub
    ))
    story.append(Spacer(1, 35))

    # Kotak Profil Mahasiswa Pengembang
    author_info = [
        [
            Paragraph("<b>Nama Mahasiswa:</b>", style_table_cell),
            Paragraph("Annisa Liandes (Ayaa)", style_table_cell),
            Paragraph("<b>Program Studi:</b>", style_table_cell),
            Paragraph("Teknik Informatika", style_table_cell)
        ],
        [
            Paragraph("<b>Nomor Induk (NIM):</b>", style_table_cell),
            Paragraph("250180123", style_table_cell),
            Paragraph("<b>Semester:</b>", style_table_cell),
            Paragraph("Semester 3 (Tiga)", style_table_cell)
        ],
        [
            Paragraph("<b>Institusi:</b>", style_table_cell),
            Paragraph("Universitas Malikussaleh (Unimal), Aceh", style_table_cell),
            Paragraph("<b>Tahun Akademik:</b>", style_table_cell),
            Paragraph("2026", style_table_cell)
        ],
        [
            Paragraph("<b>Stack Teknologi:</b>", style_table_cell),
            Paragraph("Laravel 12, PHP 8.3, Tailwind CSS, MySQL", style_table_cell),
            Paragraph("<b>Automated CI:</b>", style_table_cell),
            Paragraph("GitHub Actions (18 Tests Passed)", style_table_cell)
        ]
    ]
    table_author = Table(author_info, colWidths=[100, 155, 95, 161])
    table_author.setStyle(TableStyle([
        ('BACKGROUND', (0,0), (-1,-1), C_BG_CARD),
        ('BOX', (0,0), (-1,-1), 1, C_BORDER),
        ('INNERGRID', (0,0), (-1,-1), 0.5, C_BORDER),
        ('TOPPADDING', (0,0), (-1,-1), 7),
        ('BOTTOMPADDING', (0,0), (-1,-1), 7),
        ('LEFTPADDING', (0,0), (-1,-1), 8),
        ('RIGHTPADDING', (0,0), (-1,-1), 8),
    ]))
    story.append(table_author)

    story.append(Spacer(1, 45))
    story.append(HRFlowable(width="100%", thickness=1, color=C_SAGE, spaceAfter=15))
    story.append(Paragraph(
        "<i>\"Buku panduan ini disusun sebagai materi penguasaan sistem logistik terpadu untuk presentasi dan tanya-jawab "
        "Ujian Akhir Semester (UAS) Pemrograman Web 2.\"</i>",
        ParagraphStyle('CoverQuote', fontName='Helvetica-Oblique', fontSize=9, textColor=C_MUTED, alignment=1)
    ))

    story.append(PageBreak())

    # ========================================================
    # BAB 1: LATAR BELAKANG & KONTEKS NYATA SISTEM
    # ========================================================
    story.append(Paragraph("BAB 1: LATAR BELAKANG & KONTEKS MASALAH", style_h1))
    story.append(HRFlowable(width="100%", thickness=1.5, color=C_PINE, spaceAfter=10))

    callout_data = [[
        Paragraph(
            "<b>Poin Inti yang Harus Dipahami:</b><br/>"
            "Kopi Arabika Gayo adalah komoditas ekspor kelas dunia dengan sertifikasi Fairtrade Organik. "
            "Namun, <b>Aceh Tengah (Takengon) berada di pedalaman pegunungan (1.400 mdpl) tanpa akses pelabuhan laut langsung</b>. "
            "Untuk sampai ke pembeli di Eropa (Pelabuhan Rotterdam), kargo tidak bisa hanya mengandalkan truk saja. "
            "Kargo wajib berpindah moda: dari <b>truk berpendingin (darat)</b> menuju pelabuhan, lalu dipindahkan ke <b>kapal kontainer samudera (laut)</b>. "
            "Perpindahan antar-moda pengangkut inilah yang disebut <b>Logistik Multimoda</b>.",
            style_callout
        )
    ]]
    t_callout = Table(callout_data, colWidths=[511])
    t_callout.setStyle(TableStyle([
        ('BACKGROUND', (0,0), (-1,-1), C_EMERALD_BG),
        ('BOX', (0,0), (-1,-1), 1, C_EMERALD_BORDER),
        ('PADDING', (0,0), (-1,-1), 10),
    ]))
    story.append(t_callout)
    story.append(Spacer(1, 10))

    story.append(Paragraph("1.1 Tiga Komoditas Unggulan yang Dikelola", style_h2))
    story.append(Paragraph(
        "Sistem AgriLian CargoTrace dirancang spesifik untuk menjaga kualitas 3 komoditas dataran tinggi:",
        style_body
    ))

    commodities_table = [
        [
            Paragraph("Komoditas", style_table_head),
            Paragraph("Spesifikasi Mutu", style_table_head),
            Paragraph("Risiko & Penanganan Logistik", style_table_head)
        ],
        [
            Paragraph("<b>Kopi Arabika Gayo</b><br/>(Specialty Grade 1)", style_table_cell),
            Paragraph("Kadar air 11.5% - 12%, skor cita rasa SCA 87.5, organik Fairtrade.", style_table_cell),
            Paragraph("Rentan berjamur jika lembab. Wajib dikemas dalam kantong kedap udara <i>GrainPro</i> dan truk berpendingin (reefer).", style_table_cell)
        ],
        [
            Paragraph("<b>Kakao Dataran Tinggi</b><br/>(Fermentasi Super AA)", style_table_cell),
            Paragraph("Tingkat fermentasi 95%, kadar air 7.5%, hitungan 95–100 biji/100g.", style_table_cell),
            Paragraph("Dikemas multi-lapis vakum 50 kg untuk mencegah fermentasi sekunder selama pelayaran lintas benua.", style_table_cell)
        ],
        [
            Paragraph("<b>Minyak Nilam Gayo</b><br/>(Patchouli Oil Premium)", style_table_cell),
            Paragraph("Kadar <i>Patchouli Alcohol</i> (PA) > 32%, berat jenis 0.962 g/ml murni.", style_table_cell),
            Paragraph("Cairan atsiri bernilai sangat tinggi ($120/kg). Disimpan dalam drum baja bersegel pabean resmi Bea Cukai.", style_table_cell)
        ]
    ]
    t_comm = Table(commodities_table, colWidths=[120, 180, 211])
    t_comm.setStyle(TableStyle([
        ('BACKGROUND', (0,0), (-1,0), C_FOREST),
        ('BOX', (0,0), (-1,-1), 1, C_BORDER),
        ('INNERGRID', (0,0), (-1,-1), 0.5, C_BORDER),
        ('ROWBACKGROUNDS', (0,1), (-1,-1), [colors.white, C_BG_CARD]),
        ('PADDING', (0,0), (-1,-1), 6),
    ]))
    story.append(t_comm)
    story.append(Spacer(1, 10))

    story.append(Paragraph("1.2 Koridor Logistik 3 Tahap", style_h2))
    story.append(Paragraph(
        "<b>Tahap 1 (Jalur Darat):</b> Truk kontainer berpendingin membawa kargo menuruni jalur pegunungan Takengon &rarr; Bireuen &rarr; Pelabuhan Belawan (jarak ±420 km, durasi 12–16 jam).<br/>"
        "<b>Tahap 2 (Hub Konsolidasi):</b> Di Terminal Petikemas Belawan, kargo diperiksa Karantina Pertanian (Fitosanitari) dan Bea Cukai (dokumen PEB). Kontainer dipasang segel resmi (*customs seal*).<br/>"
        "<b>Tahap 3 (Jalur Laut Samudera):</b> Kapal kontainer (*ocean liner*) berlayar menyeberangi Selat Malaka menuju hub Singapura lalu melanjutkan pelayaran ke <b>Pelabuhan Rotterdam (Belanda)</b> selama 20–24 hari.",
        style_body
    ))

    story.append(PageBreak())

    # ========================================================
    # BAB 2: PEMBAGIAN PERAN PENGGUNA (RBAC) & SKENARIO
    # ========================================================
    story.append(Paragraph("BAB 2: PEMBAGIAN PERAN PENGGUNA (RBAC)", style_h1))
    story.append(HRFlowable(width="100%", thickness=1.5, color=C_PINE, spaceAfter=10))

    story.append(Paragraph(
        "Sistem menerapkan keamanan <b>Role-Based Access Control (RBAC)</b> ketat. Setiap aktor memiliki tugas, batasan, "
        "dan tampilan dasbor yang berbeda-beda:",
        style_body
    ))

    roles_table = [
        [
            Paragraph("Peran (Role)", style_table_head),
            Paragraph("Akun Demo", style_table_head),
            Paragraph("Wewenang Utama", style_table_head),
            Paragraph("Batasan Otorisasi", style_table_head)
        ],
        [
            Paragraph("<b>Admin Sistem</b><br/>(Super Administrator)", style_table_cell),
            Paragraph("admin@agrilian.com<br/><i>(Ayaa Liandes)</i>", style_table_cell),
            Paragraph("Melihat dasbor kontrol radar global, grafik status kargo donat, grafik tonase bar, peta sebaran GIS, telemetri cuaca, dan audit log lengkap.", style_table_cell),
            Paragraph("Akses penuh ke seluruh modul sistem.", style_table_cell)
        ],
        [
            Paragraph("<b>Operator Lapangan</b><br/>(Logistics Dispatcher)", style_table_cell),
            Paragraph("operator@agrilian.com<br/><i>(Reza Pratama)</i>", style_table_cell),
            Paragraph("<b>Menerbitkan Manifes Ekspor Baru</b>, mencatat titik pergerakan kargo (milestones), memperbarui status kargo, dan melaporkan kendala rute.", style_table_cell),
            Paragraph("Fokus pada operasional fisik harian di gudang dan terminal pelabuhan.", style_table_cell)
        ],
        [
            Paragraph("<b>Pelanggan / Buyer</b><br/>(Mitra Eksportir)", style_table_cell),
            Paragraph("buyer.amsterdam@eurocoffee.nl<br/><i>(EuroCoffee B.V.)</i>", style_table_cell),
            Paragraph("Memantau pesanan aktif miliknya, melihat grafik performa kiriman, <b>Cetak Surat Jalan A4</b>, dan <b>Lapor Klaim / Retur Barang Rusak</b>.", style_table_cell),
            Paragraph("<b>DIBLOKIR (403)</b> jika mencoba membuat manifes baru atau mengintip pesanan buyer lain.", style_table_cell)
        ],
        [
            Paragraph("<b>Tamu (Guest)</b><br/>(Pengunjung Luar)", style_table_cell),
            Paragraph("Tanpa Login", style_table_cell),
            Paragraph("Melihat Landing Page, Katalog Komoditas Gayo, dan formulir Cek Resi.", style_table_cell),
            Paragraph("Saat nomor resi dicek, otomatis diarahkan login demi keamanan data kargo.", style_table_cell)
        ]
    ]
    t_roles = Table(roles_table, colWidths=[95, 125, 180, 111])
    t_roles.setStyle(TableStyle([
        ('BACKGROUND', (0,0), (-1,0), C_FOREST),
        ('BOX', (0,0), (-1,-1), 1, C_BORDER),
        ('INNERGRID', (0,0), (-1,-1), 0.5, C_BORDER),
        ('ROWBACKGROUNDS', (0,1), (-1,-1), [colors.white, C_BG_CARD]),
        ('PADDING', (0,0), (-1,-1), 6),
    ]))
    story.append(t_roles)
    story.append(Spacer(1, 12))

    story.append(Paragraph("2.1 Alur Pengembalian Barang & Klaim Mutu bagi Pelanggan", style_h2))
    claim_box = [[
        Paragraph(
            "<b>Pertanyaan Penting Ayaa:</b> <i>\"Apakah pelanggan perlu buat manifes baru, atau pengembalian barang aja cetak resi baru?\"</i><br/>"
            "<b>Penjelasan Ahli:</b> Dalam bisnis ekspor internasional, <b>Pelanggan (Buyer di Amsterdam) TIDAK BOLEH membuat manifes pengiriman baru</b>, "
            "karena manifes adalah dokumen resmi kepabeanan yang diterbitkan gudang pengirim di Takengon.<br/>"
            "Sebagai gantinya, pelanggan disediakan alur <b>Lapor Klaim / Retur Barang (*Quality & Damage Claim*)</b>:<br/>"
            "1. Pelanggan membuka dasbor akun &rarr; Di tabel pesanan miliknya, ada tombol merah <b>'Lapor Klaim / Retur'</b>.<br/>"
            "2. Ketika diklik, muncul <b>Modal Pop-Up Web Resmi AgriLian</b>.<br/>"
            "3. Pelanggan memilih tingkat keparahan (misal: <i>Kadar Air Naik / Kantong Rusak</i>) dan menuliskan keterangan bukti inspeksi.<br/>"
            "4. Sistem secara otomatis mencatat berkas sengketa (*exception report*) dan memberi notifikasi ke Operator untuk menerbitkan resi retur pengganti.",
            style_callout
        )
    ]]
    t_claim = Table(claim_box, colWidths=[511])
    t_claim.setStyle(TableStyle([
        ('BACKGROUND', (0,0), (-1,-1), C_AMBER_BG),
        ('BOX', (0,0), (-1,-1), 1, C_AMBER_BORDER),
        ('PADDING', (0,0), (-1,-1), 9),
    ]))
    story.append(t_claim)

    story.append(PageBreak())

    # ========================================================
    # BAB 3: ALUR PERJALANAN KARGO EKSPOR (STEP-BY-STEP)
    # ========================================================
    story.append(Paragraph("BAB 3: ALUR OPERASIONAL 5 TAHAP PENGIRIMAN", style_h1))
    story.append(HRFlowable(width="100%", thickness=1.5, color=C_PINE, spaceAfter=10))

    story.append(Paragraph(
        "Berikut alur hidup (*lifecycle*) sebuah kargo mulai dari biji kopi dipanen di Takengon hingga diterima di Rotterdam:",
        style_body
    ))

    steps_data = [
        [
            Paragraph("Tahap", style_table_head),
            Paragraph("Lokasi & Aktor", style_table_head),
            Paragraph("Aksi Nyata di Dalam Sistem AgriLian", style_table_head)
        ],
        [
            Paragraph("<b>Tahap 1</b><br/>Penerbitan Manifes", style_table_cell),
            Paragraph("<b>Hub Takengon</b><br/>Operator Lapangan", style_table_cell),
            Paragraph("Operator menimbang kargo kopi, memeriksa kadar air (<12%), dan mengisi form <b>Buat Manifes Baru</b>. Sistem mencatat nomor resi unik (cth: <code>CT-9042</code>) dan status berubah jadi <code>CREATED</code>.", style_table_cell)
        ],
        [
            Paragraph("<b>Tahap 2</b><br/>Keberangkatan Truk", style_table_cell),
            Paragraph("<b>Jalur Bireuen</b><br/>Dispatcher / Supir", style_table_cell),
            Paragraph("Truk berpendingin berangkat menuruni pegunungan. Operator mencatat checkpoint pos Bireuen. Sistem mengintegrasikan API cuaca OpenWeather untuk memantau potensi longsor jalur Bireuen-Takengon.", style_table_cell)
        ],
        [
            Paragraph("<b>Tahap 3</b><br/>Pabean Pelabuhan", style_table_cell),
            Paragraph("<b>Terminal Belawan</b><br/>Petugas Bea Cukai", style_table_cell),
            Paragraph("Kontainer diperiksa sinar-X dan disahkan oleh Karantina Fitosanitari. Dipasang segel resmi (<code>ID-CUSTOMS-XXXX</code>). Status diubah menjadi <code>CUSTOMS_CLEARANCE</code> lalu dimuat ke kapal.", style_table_cell)
        ],
        [
            Paragraph("<b>Tahap 4</b><br/>Pelayaran Samudera", style_table_cell),
            Paragraph("<b>Selat Malaka - SG</b><br/>Kapal Kontainer", style_table_cell),
            Paragraph("Kapal berlayar melintasi rute maritim internasional menuju hub Singapura untuk alih muat (*transshipment*) ke kapal induk samudera Maersk Line. Radar Leaflet.js menampilkan garis rute biru laut.", style_table_cell)
        ],
        [
            Paragraph("<b>Tahap 5</b><br/>Tiba di Tujuan", style_table_cell),
            Paragraph("<b>Pelabuhan Rotterdam</b><br/>Buyer / Consignee", style_table_cell),
            Paragraph("Kargo tiba di Belanda. Pelanggan membuka web untuk memverifikasi dokumen, mencetak <b>Surat Jalan A4</b>, dan menandatangani serah terima. Status kargo tuntas menjadi <code>DELIVERED</code>.", style_table_cell)
        ]
    ]
    t_steps = Table(steps_data, colWidths=[80, 120, 311])
    t_steps.setStyle(TableStyle([
        ('BACKGROUND', (0,0), (-1,0), C_FOREST),
        ('BOX', (0,0), (-1,-1), 1, C_BORDER),
        ('INNERGRID', (0,0), (-1,-1), 0.5, C_BORDER),
        ('ROWBACKGROUNDS', (0,1), (-1,-1), [colors.white, C_BG_CARD]),
        ('PADDING', (0,0), (-1,-1), 6),
    ]))
    story.append(t_steps)
    story.append(Spacer(1, 10))

    story.append(Paragraph("3.1 Penanganan Gangguan Rute (Exception & Recalculate ETA)", style_h2))
    story.append(Paragraph(
        "Jika di tengah jalan truk tertahan akibat longsor di pegunungan Bireuen atau badai laut di Selat Malaka:<br/>"
        "1. Operator menekan tombol <b>'Laporkan Kendala Rute'</b> di rincian pengiriman.<br/>"
        "2. Operator memilih jenis kendala (<code>WEATHER_DELAY</code>, <code>PORT_CONGESTION</code>, dll.) dan estimasi jam penundaan.<br/>"
        "3. Mesin <b>EtaService</b> secara otomatis memajukan perkiraan waktu tiba (*recalculate ETA*) dan mengubah tingkat keparahan menjadi <code>LOW</code>, <code>MEDIUM</code>, atau <code>HIGH</code>.<br/>"
        "4. Notifikasi peringatan darurat otomatis muncul di lonceng notifikasi dan radar peta Leaflet berubah warna menjadi kuning/merah.",
        style_body
    ))

    story.append(PageBreak())

    # ========================================================
    # BAB 4: FITUR TEKNIS & KEUNGGULAN REKAYASA WEB
    # ========================================================
    story.append(Paragraph("BAB 4: FITUR TEKNIS & KEUNGGULAN REKAYASA", style_h1))
    story.append(HRFlowable(width="100%", thickness=1.5, color=C_PINE, spaceAfter=10))

    story.append(Paragraph("4.1 Pola Arsitektur Service Layer", style_h2))
    story.append(Paragraph(
        "Website ini tidak menumpuk semua kodingan di dalam Controller (*Fat Controller*), melainkan membaginya ke dalam <b>Service Layer</b> profesional:",
        style_body
    ))

    services_data = [
        [Paragraph("Nama Service", style_table_head), Paragraph("Tanggung Jawab Spesifik dalam Sistem", style_table_head)],
        [Paragraph("<b>ShipmentService</b>", style_table_cell), Paragraph("Mengelola siklus hidup kargo secara ketat (*state machine*). Menolak lompatan status ilegal (misal kargo baru dibuat tidak boleh langsung lompat jadi Terkirim tanpa melalui pos).", style_table_cell)],
        [Paragraph("<b>TrackingService</b>", style_table_cell), Paragraph("Mencatat riwayat audit pelacakan fisik secara kronologis dan tidak bisa dimanipulasi (*immutable audit log*).", style_table_cell)],
        [Paragraph("<b>EtaService</b>", style_table_cell), Paragraph("Mengevaluasi selisih waktu antara jadwal keberangkatan dan kedatangan untuk mendeteksi keterlambatan.", style_table_cell)],
        [Paragraph("<b>CurrencyService</b>", style_table_cell), Paragraph("Mengambil nilai tukar valuta asing resmi dari <b>Bank Sentral Eropa (ECB / Frankfurter API)</b> secara live untuk menghitung valuasi devisa ekspor dalam USD dan EUR.", style_table_cell)],
        [Paragraph("<b>WeatherService</b>", style_table_cell), Paragraph("Menghubungkan sistem ke satelit <b>OpenWeather API</b> guna membaca suhu dan curah hujan di tiap titik kargo.", style_table_cell)]
    ]
    t_serv = Table(services_data, colWidths=[140, 371])
    t_serv.setStyle(TableStyle([
        ('BACKGROUND', (0,0), (-1,0), C_FOREST),
        ('BOX', (0,0), (-1,-1), 1, C_BORDER),
        ('INNERGRID', (0,0), (-1,-1), 0.5, C_BORDER),
        ('ROWBACKGROUNDS', (0,1), (-1,-1), [colors.white, C_BG_CARD]),
        ('PADDING', (0,0), (-1,-1), 5.5),
    ]))
    story.append(t_serv)
    story.append(Spacer(1, 10))

    story.append(Paragraph("4.2 Sistem Pop-Up Toast Web Elegan (Bukan Bawaan Browser)", style_h2))
    story.append(Paragraph(
        "Website AgriLian CargoTrace <b>bebas dari dialog kuno <code>window.alert()</code> bawaan browser</b>. "
        "Sebagai gantinya, kami membangun komponen <b>Floating Web Toast Notification</b> bertema Highland Forest yang muncul di pojok kanan atas, "
        "lengkap dengan ikon status, tombol tutup `(X)`, dan otomatis menghilang dalam 5 detik.",
        style_body
    ))

    story.append(Paragraph("4.3 Surat Jalan Fisik Cetak A4 Standar Ekspor", style_h2))
    story.append(Paragraph(
        "Halaman <code>/shipments/{id}/print</code> menyajikan dokumen fisik resmi A4 yang dapat langsung dicetak atau disimpan ke PDF, dilengkapi "
        "<b>Barcode Code128</b>, <b>QR Code Pelacakan Dinamis</b>, tabel rincian muatan multi-lot, dan lembar tanda tangan sah 3 pihak.",
        style_body
    ))

    story.append(PageBreak())

    # ========================================================
    # BAB 5: PANDUAN TANYA-JAWAB UJIAN UAS (CHEAT-SHEET)
    # ========================================================
    story.append(Paragraph("BAB 5: PANDUAN TANYA-JAWAB UJIAN UAS", style_h1))
    story.append(HRFlowable(width="100%", thickness=1.5, color=C_PINE, spaceAfter=10))

    story.append(Paragraph(
        "Berikut adalah rangkuman tanya-jawab paling krusial yang dapat Ayaa gunakan saat presentasi di hadapan Dosen Penguji:",
        style_body
    ))

    qa_list = [
        (
            "1. Dosen: \"Mengapa sistem Anda disebut Logistik Multimoda? Kenapa tidak pakai truk saja?\"",
            "Jawaban Ayaa: \"Karena komoditas ini diekspor ke Eropa (Rotterdam). Takengon berada di dataran tinggi Aceh tanpa akses laut, sehingga tahap pertama wajib memakai truk berpendingin (darat). Namun truk tidak bisa menyeberang benua, sehingga di Pelabuhan Belawan muatan dialihkan ke kapal kontainer samudera (laut). Penggabungan dua moda angkutan inilah yang dinamakan logistik multimoda, Pak/Bu.\""
        ),
        (
            "2. Dosen: \"Bagaimana sistem memastikan keamanan data antar pelanggan (data isolation)?\"",
            "Jawaban Ayaa: \"Kami menerapkan Role-Based Access Control (RBAC). Saat pelanggan login, sistem menyaring kueri database secara otomatis dengan klausa where('customer_id', $user->id). Pelanggan tidak bisa melihat pesanan milik pembeli lain, dan jika sengaja membuka URL buat manifes, sistem langsung memblokir dengan kode HTTP 403 Forbidden.\""
        ),
        (
            "3. Dosen: \"Mengapa Anda memilih Leaflet.js daripada Google Maps?\"",
            "Jawaban Ayaa: \"Leaflet.js menggunakan pustaka sumber terbuka (OpenStreetMap) yang ringan, cepat, dan 100% gratis tanpa memerlukan kartu kredit atau batasan kuota tagihan API seperti Google Maps, sehingga sangat ideal dan mandiri untuk proyek sistem informasi logistik.\""
        ),
        (
            "4. Dosen: \"Bagaimana Anda menguji bahwa sistem ini bebas bug sebelum ujian?\"",
            "Jawaban Ayaa: \"Saya telah membangun 18 pengujian otomatis (Automated Unit & Feature Tests) dengan 75 assertions di framework PHPUnit. Pengujian ini juga terhubung ke GitHub Actions CI di cloud, sehingga setiap kali ada kode baru di-push, sistem langsung diuji otomatis dan mendapatkan status 'Tests: Passing'.\""
        )
    ]

    for q, a in qa_list:
        qa_table = [[
            Paragraph(f"<b>{q}</b>", style_body_bold),
        ], [
            Paragraph(f"<i>{a}</i>", style_callout),
        ]]
        t_qa = Table(qa_table, colWidths=[511])
        t_qa.setStyle(TableStyle([
            ('BACKGROUND', (0,0), (-1,0), C_BG_CARD),
            ('BACKGROUND', (0,1), (-1,1), colors.white),
            ('BOX', (0,0), (-1,-1), 1, C_BORDER),
            ('PADDING', (0,0), (-1,-1), 7),
        ]))
        story.append(t_qa)
        story.append(Spacer(1, 7))

    story.append(Spacer(1, 15))
    story.append(HRFlowable(width="100%", thickness=1, color=C_SAGE, spaceAfter=10))
    story.append(Paragraph(
        "&copy; 2026 AgriLian CargoTrace &bull; Dirancang dan Dikembangkan oleh Annisa Liandes (NIM 250180123)<br/>"
        "Program Studi Teknik Informatika &bull; Universitas Malikussaleh (Unimal), Aceh",
        ParagraphStyle('FooterNotice', fontName='Helvetica', fontSize=8, leading=11, textColor=C_MUTED, alignment=1)
    ))

    # Build PDF
    doc.build(story, canvasmaker=NumberedCanvas)
    print(f"[SUCCESS] PDF Generated successfully at: {filename}")

if __name__ == "__main__":
    build_pdf()
