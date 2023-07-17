create database tracker;
use tracker;
create table user(
accID varchar(128) not null,
name varchar(64) not null,
password varchar(256) not null,
UserType varchar(16) not null,
constraint user_pk primary key(accID)
);

create table user_housing(
accID varchar(128) not null,
area varchar(64) not null,
house_address varchar(128) not null,
constraint user_house_pk primary key (accID, house_address),
constraint user_house_fk1 foreign key (accID) references user(accID)
);

create table records(
createdatetime datetime not null,
area varchar(64) not null,
accID varchar(128) not null,
checkin tinyint not null,
checkout tinyint not null,
constraint records_pk primary key (createdatetime, accID, checkin),
constraint records_fk1 foreign key (accID) references user(accID)
);

create table admin_keys(
specialkey varchar(128) not null,
constraint admin_keys primary key (specialkey)
);

select * from user;
select * from user_housing;
select * from records;
select * from admin_keys;
insert into admin_keys values('abc123');
