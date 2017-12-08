<?php

// A default handler is included for the exception HTTP codes below
// If you'd like to use your own page, you can simply specify the 'view' to be
// the string to pass through to a view() call
//
// In order to make it easier to re-use views between errors, you can also
// specify content to pass through via 'data'. The exception code is automatically
// made available to the view as $code
return [

    400 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "Bad Request",
            'description' => "We don't know what to do with your request. Check your address and try again."
        ]
    ],

    401 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "Unauthorized",
            'description' => "You must be logged in to access this page."
        ]
    ],

    403 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "Forbidden",
            'description' => "You are not permitted to access this page."
        ]
    ],

    404 => [
        'view' => 'vendor.glove.exception',
        'debug' => false,
        'data' => [
            'name' => "Page Not Found",
            'description' => "The address you were looking for does not exist."
        ]
    ],

    405 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "Method Not Allowed",
            'description' => "The HTTP request method isn't permitted for this page. e.g. a GET request when POST is required."
        ]
    ],

    406 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "Not Acceptable",
            'description' => "The requested resource is capable of generating only content not acceptable according to the Accept headers sent in the request."
        ]
    ],

    407 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "Proxy Authentication Required",
            'description' => "You must first authenticate via the proxy before accessing this page."
        ]
    ],

    408 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "Request Timeout",
            'description' => "The request took too long and timed out. This may be due to high demand at the moment -- try again in a few minutes."
        ]
    ],

    409 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "Confict",
            'description' => "There was a conflict in determing how to respond. Please try again later."
        ]
    ],

    410 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "Gone",
            'description' => "The requested resource is no longer available"
        ]
    ],

    411 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "Length Required",
            'description' => "Request headers were missing the required content length."
        ]
    ],

    412 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "Precondition Failed (RFC 7232)",
            'description' => "The server does not meet one of the preconditions that the requester put on the request."
        ]
    ],

    413 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "Payload Too Large (RFC 7231)",
            'description' => "The request is larger than the server is willing or able to process."
        ]
    ],

    414 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "URI Too Long (RFC 7231)",
            'description' => "The URI provided was too long for the server to process. Often the result of too much data being encoded as a query-string of a GET request, in which case it should be converted to a POST request."
        ]
    ],

    415 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "Unsupported Media Type",
            'description' => "The request entity has a media type which the server or resource does not support. For example, the client uploads an image as image/svg+xml, but the server requires that images use a different format."
        ]
    ],

    416 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "Range Not Satisfiable (RFC 7233)",
            'description' => "The client has asked for a portion of the file (byte serving), but the server cannot supply that portion. For example, if the client asked for a part of the file that lies beyond the end of the file."
        ]
    ],

    417 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "Expectation Failed",
            'description' => "The server cannot meet the requirements of the Expect request-header field."
        ]
    ],

    418 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "I'm a teapot (RFC 2324)",
            'description' => "Short and stout. Here is my handle; here is my spout."
        ]
    ],

    421 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "Misdirected Request (RFC 7540)",
            'description' => "The request was directed at a server that is not able to produce a response. (for example because of a connection reuse)"
        ]
    ],

    422 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "Unprocessable Entity (WebDAV; RFC 4918)",
            'description' => "The request was well-formed but was unable to be followed due to semantic errors."
        ]
    ],

    423 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "Locked (WebDAV; RFC 4918)",
            'description' => "The resource that is being accessed is locked."
        ]
    ],

    424 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "Failed Dependency (WebDAV; RFC 4918)",
            'description' => "The request failed due to failure of a previous request (e.g., a PROPPATCH)."
        ]
    ],

    426 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "Upgrade Required",
            'description' => "The client should switch to a different protocol such as TLS/1.0, given in the Upgrade header field."
        ]
    ],

    428 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "Precondition Required (RFC 6585)",
            'description' => "The origin server requires the request to be conditional. Intended to prevent the 'lost update' problem, where a client GETs a resource's state, modifies it, and PUTs it back to the server, when meanwhile a third party has modified the state on the server, leading to a conflict."
        ]
    ],

    429 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "Too Many Requests (RFC 6585)",
            'description' => "The user has sent too many requests in a given amount of time. Intended for use with rate-limiting schemes."
        ]
    ],

    431 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "Request Header Fields Too Large (RFC 6585)",
            'description' => "The server is unwilling to process the request because either an individual header field, or all the header fields collectively, are too large."
        ]
    ],

    451 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "Unavailable For Legal Reasons (RFC 7725)",
            'description' => "A server operator has received a legal demand to deny access to a resource or to a set of resources that includes the requested resource."
        ]
    ],

    500 => [
        'view' => 'vendor.glove.exception',
        'data' => [
            'name' => "Internal System Error",
            'description' => "Something went wrong on our end trying to process your request. We'll take a look at it, but feel free to contact us and give us an idea of what you are trying to do and we'll do our best to fix it."
        ]
    ],

    501 => [
        'name' => "Not Implemented",
        'description' => "This feature isn't available yet, but good on you for trying!"
    ],

    502 => [
        'name' => "Bad Gateway",
        'description' => "The server was acting as a gateway or proxy and received an invalid response from the upstream server."

    ],

    503 => [
        'name' => "Be Right Back",
        'description' => "The server is temporarily down. Please check back later."

    ],

    504 => [
        'name' => "Gateway Timeout",
        'description' => "The server was acting as a gateway or proxy and did not receive a timely response from the upstream server."

    ],

    505 => [
        'name' => "HTTP Version Not Supported",
        'description' => "The server does not support the HTTP protocol version used in the request."

    ],

    506 => [
        'name' => "Variant Also Negotiates (RFC 2295)",
        'description' => "Transparent content negotiation for the request results in a circular reference."

    ],

    507 => [
        'name' => "Insufficient Storage (WebDAV; RFC 4918)",
        'description' => "The server is unable to store the representation needed to complete the request."

    ],

    508 => [
        'name' => "Loop Detected (WebDAV; RFC 5842)",
        'description' => "The server detected an infinite loop while processing the request (sent in lieu of '208' => ["

    ],

    510 => [
        'name' => "Not Extended (RFC 2774)",
        'description' => "Further extensions to the request are required for the server to fulfil it."

    ],

    511 => [
        'name' => "Network Authentication Required (RFC 6585)",
        'description' => "You'll need to log in to access this page."
    ],

];

// some descriptions pulled from https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
