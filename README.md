# Minimalist CloudFlare API

## _The fastest and simplest PHP CloudFlare API_

[![ZeosDev](https://i.imgur.com/hSyuS32.png)](https://github.com/ofahel/)

This project is the simplest way to manage DNS Records on CloudFlare.

Make simple things to do complex task

As [Steve Jobs][jobs_wiki] says on the [BusinessWeek, May 25 1998][jobs_quote]

> That’s been one of my mantras — focus and simplicity.
> Simple can be harder than complex:
> You have to work hard to get your thinking clean to make it simple.
> But it’s worth it in the end because once you get there, you can move mountains.

## ⚡ Features

- Easy way to manage your DNS Records.
- Create Records.
- Edit Records.
- List Zone Records.

- Lightest CloudFlare PHP API.

## 🎉 Installation/Usage

Download the cf_api.php and put it on your project folder.

Follow the example and voilà.

```php
<?php
include("cf_api.php");

//Instantiate the API class => (Email, CF Auth key, Zone ID)
$CloudFlare = new CloudFlareAPI("email@email.com", "9ca34...", "2fc20...");

//Create A DNS Record
$params = array(
              "type" => "A",
              "name" => "something",
              "content" => "8.8.8.8",
              "ttl" => 120 /*OPTIONAL*/,
              "priority" => 10 /*OPTIONAL*/,
              "proxied" => true /*OPTIONAL*/);
$CloudFlare->createRecord($params);


//Edit/Update Dns Record
$record_id = "27eeb..."; //Record ID
$params = array(
               'type' => 'A',
               'name' =>' something',
               'content' => '216.58.202.206',
               'ttl' => 10 /*OPTIONAL*/,
               'proxied' => true /*OPTIONAL*/);

$CloudFlare->updateRecord($record_id, $params);


//List DNS Records
$params = array(
              "type" => "A",
              "name" => "something",
              "proxied" => true,
              "page" => 0,
              "order" => 10,
              "content" => true);
$CloudFlare->listRecords($params /*OPTIONAL*/);


//Delete DNS Record
$record_id = "59ae3..."; //Record ID
$CloudFlare->deleteRecord($record_id);

...
```

## ✨ Create Record Parameters

| Parameter | Description                                              | Rule         | Default |
| --------- | -------------------------------------------------------- | ------------ | ------- |
| type      | More details on **Supported Types of DNS Records table** | **Needed**   |         |
| name      | The name of the DNS Record                               | **Needed**   |         |
| content   | The content of the DNS Record                            | **Needed**   |         |
| ttl       | Time to Live of the DNS Record                           | **Optional** | 120     |
| priority  | Priority are used by MX Hosts, check your host tutorial  | **Optional** | 10      |
| proxied   | Record proxied by CloudFlare                             | **Optional** | true    |

## 📄 List Records Parameters

| Parameter | Description               | Rule         |
| --------- | ------------------------- | ------------ |
| type      | Filter by Record Type     | **Optional** |
| name      | Filter by Record Name     | **Optional** |
| content   | Filter by Record Content  | **Optional** |
| ttl       | Filter by Record TTL      | **Optional** |
| priority  | Filter by Record Priority | **Optional** |
| proxied   | Filter by Record Proxied  | **Optional** |

## 🖊️ Edit/Update Record Parameters

| Parameter | Description                                              | Rule         | Default |
| --------- | -------------------------------------------------------- | ------------ | ------- |
| type      | More details on **Supported Types of DNS Records table** | **Needed**   |         |
| name      | The name of the DNS Record                               | **Needed**   |         |
| content   | The content of the DNS Record                            | **Needed**   |         |
| ttl       | Time to Live of the DNS Record                           | **Optional** | 120     |
| proxied   | Record proxied by CloudFlare                             | **Optional** | true    |

## 🧐 Supported Types of DNS Records

| Type  | Description                                                                                             |
| ----- | ------------------------------------------------------------------------------------------------------- |
| A     | The record that holds the IP address of a domain. [more...][cf_a]                                       |
| CNAME | Forwards one domain or subdomain to another domain, does NOT provide an IP address. [more...][cf_cname] |
| MX    | Directs mail to an email server. [more...][cf_mx]                                                       |
| TXT   | Lets an admin store text notes in the record. [more...][cf_txt]                                         |
| NS    | Stores the name server for a DNS entry. [more...][cf_ns]                                                |
| SOA   | Stores admin information about a domain. [more...][cf_soa]                                              |
| SRV   | Specifies a port for specific services. [more...][cf_srv]                                               |
| PTR   | Provides a domain name in reverse-lookups. [more...][cf_ptr]                                            |

## API Methods

| Method       | Description                                  | Parameters                                            |
| ------------ | -------------------------------------------- | ----------------------------------------------        |
| CURL         | Execute your own PostField to CloudFlare API | API Type, Posts (json string)                         |
| changeZone   | Change Zone prop                             | Zone(string)                                          |
| createRecord | Create a new Record                          | Array Keys(type, name, content, proxied)              |
| listRecords  | List zone DNS Records                        | Array Keys(type, name, proxied, content, page, order) |
| updateRecord | Create a new Record                          | Array Keys(type, name, content, ttl, proxied)         |
| deleteRecord | Delete a Record by their ID                  | Record ID(string)                                     |


## ️📑️ TODO

- ~~Implement (**delete**) DNS Records️~~  (Done ✔️)
- ~~Implement (**edit**) DNS Records~~    (Done ✔️)
- ~~Implement (**list**) DNS Records~~    (Done ✔️)

## Development

Want to contribute? Great!
You are welcome 🥳

## License

GNU General Public License

[//]: # "These are reference links used in the body of this note and get stripped out when the markdown processor does its job. Thanks SO - http://stackoverflow.com/questions/4823468/store-comments-in-markdown-syntax"
[jobs_wiki]: https://en.wikipedia.org/wiki/Steve_Jobs
[jobs_quote]: https://www.bloomberg.com/news/articles/1998-05-25/steve-jobs-theres-sanity-returning
[curl]: https://en.wikipedia.org/wiki/CURL
[cf_a]: https://www.cloudflare.com/learning/dns/dns-records/dns-a-record/
[cf_cname]: https://www.cloudflare.com/learning/dns/dns-records/dns-cname-record/
[cf_mx]: https://www.cloudflare.com/learning/dns/dns-records/dns-mx-record/
[cf_txt]: https://www.cloudflare.com/learning/dns/dns-records/dns-txt-record/
[cf_ns]: https://www.cloudflare.com/learning/dns/dns-records/dns-ns-record/
[cf_soa]: https://www.cloudflare.com/learning/dns/dns-records/dns-soa-record/
[cf_srv]: https://www.cloudflare.com/learning/dns/dns-records/dns-srv-record/
[cf_ptr]: https://www.cloudflare.com/learning/dns/dns-records/dns-ptr-record/
