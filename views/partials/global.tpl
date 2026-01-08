<!DOCTYPE html>
<html>
<head>
    {$headerinclude}
</head>
<body class="sidebar-mini">
    <div class="wrapper">
        {$header}
        {$content}
        {$footer}
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            let url = window.location;

            $('ul.nav-sidebar a').filter(function() {
                return (url.href.indexOf(this.href) == 0) ? true : false;
            }).addClass('active');

            $('ul.nav-treeview a').filter(function() {
                return (url.href.indexOf(this.href) == 0) ? true : false;
            }).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');
        });
    </script>
</body>
</html>
