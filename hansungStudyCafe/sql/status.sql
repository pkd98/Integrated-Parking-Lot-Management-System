create table status (
    seat char(3) not null,
    id char(15),
    name char(10),
    checkin_time char(20),
    primary key(seat)
);
INSERT INTO hansung_studycafe.status (seat) VALUES ('a1');
INSERT INTO hansung_studycafe.status (seat) VALUES ('a2');
INSERT INTO hansung_studycafe.status (seat) VALUES ('a3');
INSERT INTO hansung_studycafe.status (seat) VALUES ('a4');
INSERT INTO hansung_studycafe.status (seat) VALUES ('a5');
INSERT INTO hansung_studycafe.status (seat) VALUES ('b1');
INSERT INTO hansung_studycafe.status (seat) VALUES ('b2');
INSERT INTO hansung_studycafe.status (seat) VALUES ('b3');
INSERT INTO hansung_studycafe.status (seat) VALUES ('b4');
INSERT INTO hansung_studycafe.status (seat) VALUES ('b5');