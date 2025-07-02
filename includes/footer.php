<footer style="margin-left: 250px; padding: 20px 40px; background: #ffffff; border-top: 1px solid #e0e0e0; text-align: center; font-family: 'Poppins', sans-serif; font-size: 14px; color: #777; transition: margin-left 0.3s ease;">
    <p>© <?= date('Y') ?> Cafeteria System. Created by Arafat Osman Aden.</p>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const body = document.body;
        const sidebar = document.getElementById('sidebar');
        const toggleSidebar = document.getElementById('collapse-btn') || document.getElementById('sidebar-toggle');

        if (toggleSidebar) {
            toggleSidebar.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
                body.classList.toggle('sidebar-collapsed');
            });
        }
    });
</script>