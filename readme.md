create messages model - m done
list messages  #done
Send chat #done
revamp the chat header #done

subscriptions
Create model -m
create plan model -m
sign up seller with free plan
block uploading more than the plan can occupy

Capture result Object {
  "id": "3WB21120KM2593253",
  "intent": "CAPTURE",
  "status": "COMPLETED",
  "purchase_units": [
    {
      "reference_id": "default",
      "amount": {
        "currency_code": "GBP",
        "value": "1.00"
      },
      "payee": {
        "email_address": "sb-ohx3q24563719@business.example.com",
        "merchant_id": "GAERL7PZW8HNJ"
      },
      "shipping": {
        "name": {
          "full_name": "John Doe"
        },
        "address": {
          "address_line_1": "1 Main St",
          "admin_area_2": "San Jose",
          "admin_area_1": "CA",
          "postal_code": "95131",
          "country_code": "US"
        }
      },
      "payments": {
        "captures": [
          {
            "id": "7XF657657B550234E",
            "status": "COMPLETED",
            "amount": {
              "currency_code": "GBP",
              "value": "1.00"
            },
            "final_capture": true,
            "seller_protection": {
              "status": "ELIGIBLE",
              "dispute_categories": [
                "ITEM_NOT_RECEIVED",
                "UNAUTHORIZED_TRANSACTION"
              ]
            },
            "create_time": "2023-02-08T05:40:50Z",
            "update_time": "2023-02-08T05:40:50Z"
          }
        ]
      }
    }
  ],
  "payer": {
    "name": {
      "given_name": "John",
      "surname": "Doe"
    },
    "email_address": "sb-lujv124824241@personal.example.com",
    "payer_id": "VMDZLSST9YDYG",
    "address": {
      "country_code": "US"
    }
  },
  "create_time": "2023-02-08T05:36:40Z",
  "update_time": "2023-02-08T05:40:50Z",
  "links": [
    {
      "href": "https://api.sandbox.paypal.com/v2/checkout/orders/3WB21120KM2593253",
      "rel": "self",
      "method": "GET"
    }
  ]
}