# UniConnect

A hyper-local platform for Faculty of Technology students and the surrounding community: boarding listings, a micro-job marketplace, a bicycle/tuk-tuk ride system, a verified skills directory, and a cashless time-bank/skill-swap system — all geo-fenced to a 2-3km campus radius.

## Roles

- **Student** — search/book rooms, offer bicycle rides or request tuk-tuks, apply for gigs, build a skills profile.
- **Villager** — list boarding rooms, offer rides, post local tasks, trade produce/meals/transport for tech help.
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
├── controllers/       # Auth, Boarding, Job, Ride, Skill, Swap
├── models/            # User, Boarding, Job, Ride, Vehicle, Skill, SkillSwap
├── views/
│   ├── auth/           # login, register
│   ├── dashboard/      # student_dashboard, villager_dashboard
│   ├── boarding/       # listing grid, listing detail, post room
│   ├── rides/          # request, offer, live status
│   ├── jobs/           # feed, detail, post task, my applications
│   ├── skills/         # public profile w/ badges, directory search
│   ├── swaps/          # barter feed, propose swap, swap history
│   └── layout/         # shared header.php / footer.php
├── public/            # front controller (index.php), .htaccess, css, js
└── database/           # schema.sql
```

## Routing

`public/index.php` is a single front controller that dispatches on `REQUEST_URI` (see `.htaccess` for the rewrite rule). There is no framework — each route instantiates a controller, which loads a model and requires a view file directly.

## Notes on the schema

`Skills`, `SkillSwaps`, and the `latitude`/`longitude` columns on `Boardings`, `Rides`, and `Jobs` are part of the base schema in this repo (they were gaps in the original pitch-deck design and have since been folded in). Geo-fencing enforcement (2-3km radius check) still needs to be implemented inside the Boarding/Job/Ride controllers using the stored coordinates.
