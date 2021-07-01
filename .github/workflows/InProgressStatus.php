name: In progress status
on:
  push:
jobs:
  in-status-job:
    runs-on: ubuntu-latest
    steps:
      - name: Echo logs
        run: echo "event_name - ${{ toJson(github.event_name) }} --- action - ${{ github.event.action }} --- is_merged ${{ github.event.pull_request.merged }} --- ${{ github.head_ref }}"

      - name: login
        uses: atlassian/gajira-login@master
        env:
          JIRA_BASE_URL: ${{ secrets.JIRA_BASE_URL }}
          JIRA_USER_EMAIL: ${{ secrets.JIRA_USER_EMAIL }}
          JIRA_API_TOKEN: ${{ secrets.JIRA_API_TOKEN }}

      - name: Find Jira ticket id
        id: ticket-id
        uses: atlassian/gajira-find-issue-key@master
        with:
          from: refs/heads/${{ github.head_ref }} #branch

      - name: Find Jira ticket id with branch
        id: ticket-id-branch
        uses: atlassian/gajira-find-issue-key@master
        with:
          from: branch

      - name: Echo Jira ticket id
        run: echo "${{ steps.ticket-id.outputs.issue }}"

      - name: Echo Jira ticket id from branch
        run: echo "${{ steps.ticket-id-branch.outputs.issue }}"

      - name: Extract branch name
        shell: bash
        run: echo "##[set-output name=branch;]$(echo ${GITHUB_REF#refs/heads/})"
        id: extract_branch

      - name: Echo branch name
        run: echo "${{ steps.extract_branch.outputs.branch }}"

      - name: Move to In progress status #Move to Code Review status
        uses: atlassian/gajira-transition@master
        with:
          issue: ${{ steps.ticket-id-branch.outputs.issue }}
          transition: "In Progress" # Code review
#
##      - name: Move to Ready For Test status
##        uses: atlassian/gajira-transition@mastergithub.event.pull_request.merged
##        if: github.event_name == 'pull_request' && github.event.action == 'opened'
##        with:
##          issue: ${{ steps.ticketId.outputs.issue }}
##          transition: "To Do" # Ready For Test
#
#      - name: Move to Merged status
#        uses: atlassian/gajira-transition@master
#        if:  == 'true'
#        with:
#          issue: ${{ steps.ticket-id.outputs.issue }}
#          transition: "Done" # Merged
