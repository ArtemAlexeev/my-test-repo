name: Test status
on:
  pull_request:
jobs:
  test-status-job:
    runs-on: ubuntu-latest
    steps:
      - name: debug github object On pull
        run: echo "${{ toJson(github) }}"