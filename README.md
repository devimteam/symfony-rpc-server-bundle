# Devim RPC Server Bundle

Third-party bundle provide annotation which define rpc endpoints

### How to setup

1. Install it with composer
2. Create **config/packages/devim_rpc_server.yaml**

        devim_rpc_server:
          classes: ~

3. Update **config/routes.yaml**
    
        rpc:
            prefix: /json-rpc
            resource: '@DevimRpcServerBundle/Resources/config/routes.yaml'

4. dfdfd


### How to use

1. Create controller with annotation **JsonRpcApi**
2. Create method with annotation **JsonRpcMethod**
3. Add controller's class to bundle configuration

        devim_rpc_server:
          classes:
            - \App\Controller\FeedbackController

4. Send RPC request to application