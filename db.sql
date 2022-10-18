.mode columns
.headers on
PRAGMA foreign_keys = ON;

drop table if exists ACCOUNT;
drop table if exists CoverImage;
drop table if exists PerfilImage;
drop table if exists USER;
drop table if exists ADMINISTRATOR;
drop table if exists MANAGER;
drop table if exists EVENTS;
drop table if exists TAG;
drop table if exists EventTag;
drop table if exists TICKET;
drop table if exists UserTicketEvent;
drop table if exists INVITE;
drop table if exists NOTIFICATIONS;
drop table if exists InviteNotification;
drop table if exists COMMENT;
drop table if exists CommentNotification;
drop table if exists ANSWER;
drop table if exists POLL;
drop table if exists PollOption;
drop table if exists VOTE;
drop table if exists REPORT;

DROP TYPE IF EXISTS privacy;

-- Types

CREATE TYPE privacy as ENUM (
    'Private',
    'Public'
    );


-- Tables


CREATE TABLE ACCOUNT (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    email       TEXT NOT NULL,
    name        TEXT NOT NULL,
    password    TEXT NOT NULL,
    description TEXT,
    age         INTEGER CHECK (age > 0),
    UNIQUE(email)
);

CREATE TABLE CoverImage (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    events_id   INTEGER NOT NULL,
    path        TEXT NOT NULL,
    CONSTRAINT fk_events_id FOREIGN KEY(events_id) REFERENCES EVENTS(id),
    UNIQUE(events_id)
);

CREATE TABLE PerfilImage (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    account_id  INTEGER DEFAULT -1,
    path        TEXT NOT NULL,
    CONSTRAINT fk_account_id FOREIGN KEY(account_id) REFERENCES ACCOUNT(id),
    UNIQUE(account_id)
);

CREATE TABLE USER (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    account_id  INTEGER DEFAULT -1,
    CONSTRAINT fk_account_id  FOREIGN KEY(account_id) REFERENCES ACCOUNT(id)
);

CREATE TABLE ADMINISTRATOR (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    account_id  INTEGER DEFAULT -1,
    CONSTRAINT fk_account_id  FOREIGN KEY(account_id) REFERENCES ACCOUNT(id)
);

CREATE TABLE MANAGER (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    account_id  INTEGER DEFAULT -1,
    event_id    INTEGER NOT NULL,
    CONSTRAINT fk_account_id  FOREIGN KEY(account_id) REFERENCES ACCOUNT(id),
    CONSTRAINT fk_event_id  FOREIGN KEY(event_id) REFERENCES EVENTS(id),
    UNIQUE(account_id, event_id)
);

CREATE TABLE EVENTS (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    name        TEXT NOT NULL,
    description TEXT,
    start_date  DATE NOT NULL,
    end_date    DATE NOT NULL,
    location    TEXT NOT NULL,
    capacity    INTEGER NOT NULL,
    privacy     privacy DEFAULT 'Public', 
    CHECK (start_date < end_date),
    CHECK (capacity > 0)
);

CREATE TABLE TAG (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    name        TEXT NOT NULL,
    UNIQUE(name)
);

CREATE TABLE EventTag (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    event_id    INTEGER NOT NULL,
    tag_id      INTEGER NOT NULL,
    CONSTRAINT fk_event_id  FOREIGN KEY(event_id) REFERENCES EVENTS(id),
    CONSTRAINT fk_tag_id  FOREIGN KEY(tag_id) REFERENCES TAG(id),
    UNIQUE(event_id, tag_id)
);

CREATE TABLE TICKET (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    price       REAL DEFAULT 0
);

CREATE TABLE UserTicketEvent (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id     INTEGER DEFAULT -1,
    event_id    INTEGER NOT NULL,
    ticket_id   INTEGER NOT NULL,
    num_tickets INTEGER CHECK (num_tickets > 0),
    CONSTRAINT fk_user_id  FOREIGN KEY(user_id) REFERENCES USER(id),
    CONSTRAINT fk_event_id  FOREIGN KEY(event_id) REFERENCES EVENTS(id),
    CONSTRAINT fk_ticket_id  FOREIGN KEY(ticket_id) REFERENCES TICKET(id),
    UNIQUE(user_id, event_id, ticket_id)
);

CREATE TABLE INVITE (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id     INTEGER DEFAULT -1,
    event_id    INTEGER NOT NULL,
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES USER(id),
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) REFERENCES EVENTS(id),
    UNIQUE(user_id, event_id)
);

CREATE TABLE NOTIFICATIONS (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id     INTEGER DEFAULT -1,
    event_id    INTEGER NOT NULL,
    content     TEXT,
    seen        BOOLEAN DEFAULT 0,
    sent_date        DATE NOT NULL,
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES USER(id),
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) REFERENCES EVENTS(id)
);

CREATE TABLE InviteNotification (
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    notification_id INTEGER NOT NULL,
    invite_id       INTEGER NOT NULL,
    user_id         INTEGER DEFAULT -1,
    CONSTRAINT fk_notification_id FOREIGN KEY(notification_id) REFERENCES NOTIFICATIONS(id),
    CONSTRAINT fk_invite_id FOREIGN KEY(invite_id) REFERENCES INVITE(id),
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES USER(id),
    UNIQUE(notification_id, invite_id, user_id)
);

CREATE TABLE COMMENT (
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id         INTEGER DEFAULT -1,
    event_id        INTEGER NOT NULL,
    content         TEXT NOT NULL,
    written_date    DATE NOT NULL CHECK (written_date <= CURRENT_DATE),
    edited          BOOLEAN DEFAULT 0,
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES USER(id),
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) REFERENCES EVENTS(id)
);

CREATE TABLE CommentNotification (
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    notification_id INTEGER NOT NULL,
    comment_id      INTEGER NOT NULL,
    user_id         INTEGER DEFAULT -1,
    CONSTRAINT fk_notification_id FOREIGN KEY(notification_id) REFERENCES NOTIFICATIONS(id),
    CONSTRAINT fk_comment_id FOREIGN KEY(comment_id) REFERENCES COMMENT(id),
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES USER(id),
    UNIQUE(notification_id, comment_id, user_id)
);

CREATE TABLE ANSWER (
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    comment_id      INTEGER NOT NULL,
    answer_id       INTEGER NOT NULL,
    CONSTRAINT fk_comment_id FOREIGN KEY(comment_id) REFERENCES COMMENT(id),
    CONSTRAINT fk_answer_id FOREIGN KEY(answer_id) REFERENCES COMMENT(id),
    UNIQUE(answer_id)
);

CREATE TABLE POLL (
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    event_id        INTEGER NOT NULL,
    question        TEXT NOT NULL,
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) REFERENCES EVENTS(id)
);

CREATE TABLE PollOption (
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    poll_id         INTEGER NOT NULL,
    description     TEXT NOT NULL,
    votes           INTEGER DEFAULT 0,
    CONSTRAINT fk_poll_id FOREIGN KEY(poll_id) REFERENCES POLL(id),
    UNIQUE(id, poll_id)
);

CREATE TABLE VOTE (
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id         INTEGER DEFAULT -1,
    poll_option_id  INTEGER NOT NULL,
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES USER(id),
    CONSTRAINT fk_polloption_id FOREIGN KEY(poll_option_id) REFERENCES PollOption(id),
    UNIQUE(user_id)
);

CREATE TABLE REPORT (
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id         INTEGER DEFAULT -1,
    event_id        INTEGER NOT NULL,
    content         TEXT NOT NULL,
    written_date    DATE NOT NULL CHECK (written_date <= CURRENT_DATE),
    CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES USER(id),
    CONSTRAINT fk_event_id FOREIGN KEY(event_id) REFERENCES EVENTS(id)
);

