name: Test on Pull_request review
on:
  pull_request_review:
jobs:
  test-on-pull-job:
    runs-on: ubuntu-latest
    steps:
      - name: Echo github
        run: echo "state - ${{ toJson(github) }} " # no mergable properties

      - name: Echo event
        run: echo "state - ${{ toJson(github.event) }}"

      - name: Echo event pull_request
        run: echo "state - ${{ toJson(github.event.pull_request) }}"

      - name: Echo branch
        run: echo "${{ toJson(github.head_ref) }}"

      - name: Echo mergable
        run: echo "${{ toJson(github.event.pull_request.mergeable) }} ---  ${{ toJson(github.event.pull_request.mergeable_state) }} --- ${{ toJson(github.event.pull_request.merge_commit_sha) }}"
