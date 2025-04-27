# jp

To install dependencies:

```bash
bun install
```

To run:

```bash
bun run index.ts
```

This project was created using `bun init` in bun v1.2.0. [Bun](https://bun.sh) is a fast all-in-one JavaScript runtime.


## Quick scripts

Test an endpoint:

```bash
curl -X POST https://academy.jasonpantana.com/wp-json/jp/v1/usersbyemail \
-d '{"emails":["joshmk93@gmail.com"]}' \
-H "Authorization: Basic Sm9zaEtlbm5lZHk6SVk3QkYzUklWbTIyVnlSZGJURWhJM2s0"
```

how to get basic auth:
```sh
echo "username:password" | base64
```
