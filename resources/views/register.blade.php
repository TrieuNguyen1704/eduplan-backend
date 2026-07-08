<!DOCTYPE html>
<html>
<body>
    <h2>Đăng ký tài khoản EduPlan</h2>
    <form action="/register" method="POST">
        @csrf <!-- Rất quan trọng trong Laravel để bảo mật -->
        <label>Tên người dùng:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Mật khẩu:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Đăng ký</button>
    </form>
</body>
</html>
