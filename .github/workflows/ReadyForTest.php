name: Ready for Test status
on:
  pull_request_review:
    types: [submitted]
jobs:
  ready-for-test-job:
    runs-on: ubuntu-latest
    #if: github.event.pull_request.mergeable == true
    steps:
      - name: Echo github
        #if: github.event.review.state == 'approved' && github.event.pull_request.mergeable == 'true'
        run: echo "state - ${{ toJson(github) }} " # no mergable properties

      - name: Echo event
        #if: github.event.review.state == 'approved' && github.event.pull_request.mergeable == 'true'
        run: echo "state - ${{ github.event.review.state }} --- branch - ${{ toJson(github.head_ref) }}"

      - name: Echo pull_request # no mergeble
        run: echo "${{ toJson(github.event.pull_request) }} "

      - name: Echo mergeable # all empty
        run: echo "${{ github.event.pull_request.mergeable }} --- ${{ github.event.mergeable }} ---  ${{ github.mergeable }}"

      - name: Branch head
        run: echo " --- branch - ${{ toJson(github.event.pull_request.head.ref) }}" # empty
