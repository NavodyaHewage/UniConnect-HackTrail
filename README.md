# UniConnect

A hyper-local platform for Faculty of Technology students and the surrounding community: boarding listings, a micro-job marketplace, a verified skills directory with paid classes, and a cashless time-bank/skill-swap system — all geo-fenced to a 2-3km campus radius.

## Roles

- **Student** — search/book rooms, apply for gigs, build a skills profile, and post individual or group classes for village students to earn money.
- **Villager** — list boarding rooms, post local tasks, browse and enroll in student-taught classes, trade produce/meals/transport for tech help.
- **Admin** — verifies listings, moderates jobs, manages skill badges (gated via the `user_role` flag on `Users`).

## Stack

PHP 8.x (PDO, no framework) + MySQL + Bootstrap 5, served by Apache/WAMP.

## Setup

1. Create a MySQL database named `uniconnect` and import [database/schema.sql](database/schema.sql).
2. Copy `.env.example` to `.env` (or set the equivalent environment variables) and adjust DB credentials.
3. Point your WAMP vhost / Apache document root at the `public/` directory.
4. Visit `/register` to create a Student or Villager account.

## Directory Structure

```
uniconnect/
├── config/            # PDO database connection setup
├── controllers/       # Auth, Boarding, Job, Class, Skill, Swap
├── models/            # User, Boarding, Job, ClassListing, ClassEnrollment, Skill, SkillSwap
├── views/
│   ├── auth/           # login, register
│   ├── dashboard/      # student_dashboard, villager_dashboard
│   ├── boarding/       # listing grid, listing detail, post room
│   ├── jobs/           # feed, detail, post task, my applications
│   ├── skills/         # public profile w/ badges, directory search
│   ├── classes/        # nested under Skills (/skills/classes/*): browse, post, detail + enroll, my classes/earnings
│   ├── swaps/          # barter feed, propose swap, swap history
│   └── layout/         # shared header.php / footer.php
├── public/            # front controller (index.php), .htaccess, css, js
└── database/           # schema.sql
```

## Routing

`public/index.php` is a single front controller that dispatches on `REQUEST_URI` (see `.htaccess` for the rewrite rule). There is no framework — each route instantiates a controller, which loads a model and requires a view file directly.

## Notes on the schema

`Skills` and `SkillSwaps` are part of the base schema in this repo (they were gaps in the original pitch-deck design and have since been folded in). `Boardings` no longer stores coordinates. The ride-sharing feature (`Rides`/`Vehicles` tables, `RideController`, `views/rides/`) has been removed from the app.

`Classes` holds individual or group classes posted by students (subject, price per student, max seats, schedule); `ClassEnrollments` tracks which villagers signed up and whether the tutor has confirmed them (`confirmed` enrollments count toward the tutor's earnings shown on `/skills/classes/my`). Classes live under the Skills category — routed at `/skills/classes/*` and reached via the Skills Directory page rather than a separate top-level nav item.
