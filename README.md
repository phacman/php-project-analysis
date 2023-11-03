# Project Analysis
Complex Project Analysis: server, php.ini, phpinfo(), etc.

Information is output to the console in the form of a table.

## Getting Started

Installation
```shell
composer require phacman/php-project-analysis
```

After installation, the script will be available in the `/vendor/bin` directory. 
To start analysis just run the following command `/vendor/bin/analysis COMMAND` in the console.

For ease of use, you can enter the word "analysis" in the "scripts" section of your composer file. 
Like this 
```json
{
  "scripts": {
    "analysis": "analysis",
    "format-code": "php-cs-fixer fix --allow-risky=yes"
  }
}
```
After that you can perform it this way `composer analysis COMMAND`.

#### Launch examples

```shell
php analysis phpini
```
```shell
./vendor/bin/analysis phpini
```
```shell
composer analysis phpini
```

If you try to run the analysis without a qualifying command, you will receive a similar warning.

```shell
You should enter one of the commands:
 - classes:  Exploring src/tests classes
 - phpinfo:  phpinfo() function data
 - phpini:  php.ini file data
 - server:  $_SERVER array data
```

If the analysis is successful, a table will be displayed in the console.

## Report Examples
#### src/tests classes
```
+-----------------------+----------+-----------+--- Exploring src/tests classes -------------+-------------------+-----------------+
| type                  | qty      | constants | properties | methods_total | public_methods | protected_methods | private_methods |
+-----------------------+----------+-----------+------------+---------------+----------------+-------------------+-----------------+
|                                      -------------------- src/ classes --------------------                                      |
|                       | 1        | 0         | 0          | 0             | 0              | 0                 | 0               |
| class                 | 60       | 10        | 69         | 285           | 223            | 9                 | 53              |
| enum                  | 1        | 0         | 0          | 0             | 0              | 0                 | 0               |
| interface             | 13       | 1         | 0          | 23            | 23             | 0                 | 0               |
| trait                 | 1        | 0         | 0          | 0             | 0              | 0                 | 0               |
+-----------------------+----------+-----------+------------+---------------+----------------+-------------------+-----------------+
|                                     -------------------- tests/ classes --------------------                                     |
|                       | 44       | 0         | 0          | 0             | 0              | 0                 | 0               |
| class                 | 131      | 13        | 96         | 411           | 388            | 15                | 8               |
| enum                  | 2        | 0         | 1          | 4             | 1              | 0                 | 3               |
| interface             | 7        | 0         | 0          | 6             | 6              | 0                 | 0               |
| trait                 | 1        | 0         | 5          | 9             | 7              | 0                 | 2               |
+-----------------------+----------+-----------+--- Exploring src/tests classes -------------+-------------------+-----------------+
```

#### php.ini
```
+----------------------------------------+-------------------- php.ini file data --+----------------------------------------------------------+
| #1                                     | #2                                      | #3                                                       |
+----------------------------------------+-----------------------------------------+----------------------------------------------------------+
|                                                ---------- /etc/php/8.1/cli/php.ini ----------                                               |
+----------------------------------------+-----------------------------------------+----------------------------------------------------------+
| engine: 1                              | short_open_tag:                         | precision: 14                                            |
| output_buffering: 4096                 | zlib.output_compression:                | implicit_flush:                                          |
| unserialize_callback_func:             | serialize_precision: -1                 | disable_functions:                                       |
| disable_classes:                       | zend.enable_gc: 1                       | zend.exception_ignore_args: 1                            |
| zend.exception_string_param_max_len: 0 | expose_php: 1                           | max_execution_time: 30                                   |
| max_input_time: 60                     | memory_limit: -1                        | error_reporting: 22527                                   |
| display_errors:                        | display_startup_errors:                 | log_errors: 1                                            |
| ignore_repeated_errors:                | ignore_repeated_source:                 | report_memleaks: 1                                       |
| ...                                    | ...                                     | ...                                                      |
| variables_order: GPCS                  | request_order: GP                       | register_argc_argv:                                      |
| session.referer_check:                 | session.cache_limiter: nocache          | session.cache_expire: 180                                |
| session.use_trans_sid: 0               | session.sid_length: 26                  | session.trans_sid_tags: a=href,area=href,frame=src,form= |
| session.sid_bits_per_character: 5      | zend.assertions: -1                     | tidy.clean_output:                                       |
| soap.wsdl_cache_enabled: 1             | soap.wsdl_cache_dir: /tmp               | soap.wsdl_cache_ttl: 86400                               |
| soap.wsdl_cache_limit: 5               | ldap.max_links: -1                      |                                                          |
+----------------------------------------+-----------------------------------------+----------------------------------------------------------+
|                                                ---------- /etc/php/8.1/cli/php.ini ----------                                               |
+----------------------------------------+-------------------- php.ini file data --+----------------------------------------------------------+
```
