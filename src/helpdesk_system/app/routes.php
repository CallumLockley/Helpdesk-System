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

//Knowledge Center
require 'routes/dashboard/knowledgeCentre/knowledge_centre.php';

//Ticket Functionality
require 'routes/dashboard/ticket/viewTickets/view_tickets.php';
require 'routes/dashboard/ticket/viewAllTickets/view_all_tickets.php';
require 'routes/dashboard/ticket/viewTickets/view_specific.php';
require 'routes/dashboard/ticket/resolveTicket.php';
require 'routes/dashboard/ticket/comments/newComment.php';

//Setting Functionality
require 'routes/dashboard/settings/settings.php';
require 'routes/dashboard/settings/update_password.php';

//Admin Functionality
require 'routes/dashboard/admin/admin_panel.php';

//create user
require 'routes/dashboard/createUser/create_user.php';
require 'routes/dashboard/createUser/process_user.php';

