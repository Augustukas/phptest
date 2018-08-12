create table messagingboard.messages
(
  messageId   int auto_increment,
  fullname    varchar(255) not null,
  birthday    date         not null,
  email       varchar(255) null,
  message     varchar(300) not null,
  messageTime datetime     not null,
  constraint messages_messageId_uindex
  unique (messageId)
)
  comment 'all messages from messaging board';

create index messages_fullname_index
  on messagingboard.messages (fullname);

alter table messagingboard.messages
  add primary key (messageId);

