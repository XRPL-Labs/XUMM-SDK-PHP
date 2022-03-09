# Creating a payload

Create a payload by passing a `PayloadJson` or a `PayloadBlob` object to `XummSdk::createPayload`.
A basic payload array could look like this:
```
[
    "txjson": {
        "TransactionType": "SignIn"
    }    
]
```