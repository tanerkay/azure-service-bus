# Azure Service Bus SDK for PHP

This is a repo built from a fork by github user `sn123` of the no longer maintained Azure SDK for PHP. This now only focuses on bringing Service Bus to PHP. This fork does not have support for Tables, Blobs, Media Services, Management.

All unit tests were run after the code cleanup and few still fail. This is pretty much work in progress - please help us in testing this library/SDK.

# Features

* Service Bus
  * Queues:
      - create, list and delete queues
      - send, receive, unlock and delete messages
  * Topics
      - create, list, and delete topics
      - create, list, and delete subscriptions
      - send, receive, unlock and delete messages
      - create, list and delete rules

# Getting Started

`composer require tanerkay/azure-service-bus`
  
# Usage

## Getting Started

* To instantiate the service client you will also need a valid connection string. The format is:

  * For accessing a live storage service (tables, blobs, queues):

    ```
    DefaultEndpointsProtocol=[http|https];AccountName=[yourAccount];AccountKey=[yourKey]
    ```

  * For accessing the emulator storage:

    ```
    UseDevelopmentStorage=true
    ```

  * For accessing the Service Bus:

    ```
    Endpoint=[yourEndpoint];SharedSecretIssuer=[yourWrapAuthenticationName];SharedSecretValue=[yourWrapPassword]
    ```

    Where the Endpoint is typically of the format `https://[yourNamespace].servicebus.windows.net`.

  * For accessing Service Management APIs:

    ```
    SubscriptionID=[yourSubscriptionId];CertificatePath=[filePathToYourCertificate]
    ```


* Instantiate a "REST Proxy" - a wrapper around the available calls for the given service.

  * For Service Bus:

    ```php
    $serviceBusRestProxy = ServicesBuilder::getInstance()->createServiceBusService($connectionString);
    ```

## Service Bus Queues
The current PHP Service Bus APIs only support ACS connection strings. You need to use PowerShell to create a new ACS Service Bus namespace at the present time.
First, make sure you have Azure PowerShell installed, then in a PowerShell command prompt, run
```PowerShell
Add-AzureAccount # this will sign you in
New-AzureSBNamespace -CreateACSNamespace $true -Name 'mytestbusname' -Location 'West US' -NamespaceType 'Messaging'
```
If it is successful, you will get the connection string in the PowerShell output. If you get connection errors with it and the conection string looks like Endpoint=sb://..., change it to **Endpoint=https://...**

### Create a Queue

```PHP
try {
    $queueInfo = new QueueInfo("myqueue");

    // Create queue.
    $serviceBusRestProxy->createQueue($queueInfo);
} catch(ServiceException $e){
    $code = $e->getCode();
    $error_message = $e->getMessage();
    echo $code.": ".$error_message."<br />";
}
```

[Error Codes and Messages](http://msdn.microsoft.com/en-us/library/windowsazure/dd179357)

### Send a Message

To send a message to a Service Bus queue, your application will call the **ServiceBusRestProxy->sendQueueMessage** method. Messages sent to (and received from ) Service Bus queues are instances
of the **BrokeredMessage** class.

```PHP
try {
  // Create message.
  $message = new BrokeredMessage();
  $message->setBody("my message");

  // Send message.
  $serviceBusRestProxy->sendQueueMessage("myqueue", $message);
} catch(ServiceException $e){
  $code = $e->getCode();
  $error_message = $e->getMessage();
  echo $code.": ".$error_message."<br />";
}
```

### Receive a Message

The primary way to receive messages from a queue is to use a **ServiceBusRestProxy->receiveQueueMessage** method. Messages can be received in two different modes: **ReceiveAndDelete** (mark message as consumed on read) and **PeekLock** (locks message for a period of time, but does not delete).

The example below demonstrates how a message can be received and processed using **PeekLock** mode (not the default mode).

```PHP
try {
  // Set the receive mode to PeekLock (default is ReceiveAndDelete).
  $options = new ReceiveMessageOptions();
  $options->setPeekLock(true);

  // Receive message.
  $message = $serviceBusRestProxy->receiveQueueMessage("myqueue", $options);
  echo "Body: ".$message->getBody()."<br />";
  echo "MessageID: ".$message->getMessageId()."<br />";

  // *** Process message here ***

  // Delete message.
  $serviceBusRestProxy->deleteMessage($message);
} catch(ServiceException $e){
  $code = $e->getCode();
  $error_message = $e->getMessage();
  echo $code.": ".$error_message."<br />";
}
```

## Service Bus Topics

### Create a Topic

```PHP
try {
  // Create topic.
  $topicInfo = new TopicInfo("mytopic");
  $serviceBusRestProxy->createTopic($topicInfo);
} catch(ServiceException $e){
  $code = $e->getCode();
  $error_message = $e->getMessage();
  echo $code.": ".$error_message."<br />";
}
```

### Create a subscription with the default (MatchAll) filter

```PHP
try {
  // Create subscription.
  $subscriptionInfo = new SubscriptionInfo("mysubscription");
  $serviceBusRestProxy->createSubscription("mytopic", $subscriptionInfo);
} catch(ServiceException $e){
  $code = $e->getCode();
  $error_message = $e->getMessage();
  echo $code.": ".$error_message."<br />";
}
```

### Send a message to a topic

Messages sent to Service Bus topics are instances of the **BrokeredMessage** class.

```PHP
try {
  // Create message.
  $message = new BrokeredMessage();
  $message->setBody("my message");

  // Send message.
  $serviceBusRestProxy->sendTopicMessage("mytopic", $message);
} catch(ServiceException $e){
  $code = $e->getCode();
  $error_message = $e->getMessage();
  echo $code.": ".$error_message."<br />";
}
```

### Receive a message from a topic

The primary way to receive messages from a subscription is to use a **ServiceBusRestProxy->receiveSubscriptionMessage** method. Received messages can work in two different modes: **ReceiveAndDelete** (the default) and **PeekLock** similarly to Service Bus Queues.

The example below demonstrates how a message can be received and processed using **ReceiveAndDelete** mode (the default mode).

```PHP
try {
  // Set receive mode to PeekLock (default is ReceiveAndDelete)
  $options = new ReceiveMessageOptions();
  $options->setReceiveAndDelete();

  // Get message.
  $message = $serviceBusRestProxy->receiveSubscriptionMessage("mytopic",
                                "mysubscription",
                                $options);
  echo "Body: ".$message->getBody()."<br />";
  echo "MessageID: ".$message->getMessageId()."<br />";
} catch(ServiceException $e){
  $code = $e->getCode();
  $error_message = $e->getMessage();
  echo $code.": ".$error_message."<br />";
}
```
