create table members (
    num int not null auto_increment,
    id char(15) not null,
    pass char(15) not null,
    name char(10) not null,
    email char(80),
    regist_day char(20),
    level int,
    primary key(num)
);