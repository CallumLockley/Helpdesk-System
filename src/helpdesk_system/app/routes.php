<?php

//Login Routing

require 'routes/login.php';
require 'routes/auth/auth.php';

//Dashboard Routing

require 'routes/dashboard/dashboard.php';
require 'routes/logout.php';

//Dashboard Options
require 'routes/dashboard/createTicket/create_ticket.php';
require 'routes/dashboard/createTicket/process_ticket.php';

require 'routes/dashboard/viewTickets/view_tickets.php';
require 'routes/dashboard/viewAllTickets/view_all_tickets.php';
require 'routes/dashboard/viewTickets/view_specific.php';
require 'routes/comments/newComment.php';

require 'routes/dashboard/settings/settings.php';
require 'routes/dashboard/settings/update_password.php';

require 'routes/dashboard/admin/admin_panel.php';
