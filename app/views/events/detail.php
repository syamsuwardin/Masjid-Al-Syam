<section class="hero">
    <div class="container">
        <h2>Detail Acara</h2>
        <p>Informasi lengkap mengenai acara yang akan datang.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <h3><?php echo $event['title']; ?></h3>
        <p><?php echo $event['description']; ?></p>
        <p><strong>Tanggal:</strong> <?php echo $event['date']; ?></p>
        <p><strong>Waktu:</strong> <?php echo $event['time']; ?></p>
        <p><strong>Tempat:</strong> <?php echo $event['location']; ?></p>
    </div>
</section>

<section class="section">
    <div class="container">
        <h4>Pesan untuk Acara Ini</h4>
        <form action="/events/register" method="post">
            <div class="form-group">
                <label for="name">Nama:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <button type="submit">Daftar</button>
        </form>
    </div>
</section>